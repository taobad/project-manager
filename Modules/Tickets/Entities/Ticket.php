<?php

namespace Modules\Tickets\Entities;

use App\Entities\Department;
use App\Entities\Priority;
use App\Entities\Status;
use App\Traits\Actionable;
use App\Traits\BelongsToUser;
use App\Traits\Commentable;
use App\Traits\Customizable;
use App\Traits\Observable;
use App\Traits\Remindable;
use App\Traits\Reviewable;
use App\Traits\Searchable;
use App\Traits\Taggable;
use App\Traits\Todoable;
use App\Traits\Uploadable;
use App\Traits\Vaultable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Tasks\Entities\Task;
use Modules\Tickets\Events\TicketClosed;
use Modules\Tickets\Events\TicketCreated;
use Modules\Tickets\Events\TicketDeleted;
use Modules\Tickets\Events\TicketOpened;
use Modules\Tickets\Jobs\TicketAssigner;
use Modules\Tickets\Notifications\TicketRepliedAlert;
use Modules\Tickets\Observers\TicketObserver;
use Modules\Tickets\Scopes\TicketScope;
use Modules\Users\Entities\User;
use Modules\Users\Entities\UserHasDepartment;

class Ticket extends Model
{
    use Commentable, Actionable, Taggable, Vaultable, Customizable, Observable,
    Reviewable, Uploadable, Searchable, BelongsToUser, Remindable, Todoable, HasFactory;

    protected static $observer = TicketObserver::class;
    protected static $scope = TicketScope::class;

    protected $fillable = [
        'code', 'subject', 'body', 'status', 'department', 'user_id', 'project_id', 'priority', 'due_date', 'is_locked',
        'locked_by', 'locked_time', 'rated', 'closed_at', 'closed_by', 'token', 'assignee', 'resolution_time', 'archived_at',
        'todo_percent', 'feedback_disabled', 'response_status',
    ];
    protected $dates = ['due_date', 'locked_time'];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TicketCreated::class,
        'deleted' => TicketDeleted::class,
    ];

    public function AsStatus()
    {
        return $this->belongsTo(Status::class, 'status');
    }

    public function AsPriority()
    {
        return $this->belongsTo(Priority::class, 'priority');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'assignee', 'id');
    }

    public function activeAgent()
    {
        return $this->belongsTo(User::class, 'locked_by', 'id');
    }

    public function dept()
    {
        return $this->belongsTo(Department::class, 'department', 'deptid');
    }

    public function isAgent()
    {
        return UserHasDepartment::where('department_id', $this->department)->where('user_id', \Auth::id())->count();
    }

    /**
     * Check if user can download files
     *
     * @param  boolean $user The user id
     * @return boolean
     */
    public function canDownloadFiles($user = false)
    {
        return $this->isAgent() || \Auth::user()->id == $this->user_id;
    }

    public function commentAlert($comment)
    {
        if ($comment->user_id == $this->user_id) {
            return $this->agent->notify(new TicketRepliedAlert($this, $comment));
        } else {
            return $this->user->notify(new TicketRepliedAlert($this, $comment));
        }
    }

    public function statusIcon()
    {
        if ($this->isLocked()) {
            return '<i class="fas fa-lock text-danger"></i> ';
        }
        if (!is_null($this->closed_at)) {
            return '<span class="text-success">✔</span> ';
        }
        if (strtolower($this->AsStatus->status) === 'pending') {
            return '<i class="fas fa-exclamation-circle text-warning"></i> ';
        }
        return '<span class="text-danger">✘</span> ';
    }

    public function nextCode()
    {
        $code = get_option('ticket_prefix') . sprintf('%04d', get_option('ticket_start_no'));
        $max = $this->withoutGlobalScopes()->whereNotNull('code')->max('id');
        if ($max > 0) {
            $row = $this->withoutGlobalScopes()->find($max);
            $ref_number = intval(substr($row->code, -4));
            $next_number = $ref_number + 1;
            if ($next_number < get_option('ticket_start_no')) {
                $next_number = get_option('ticket_start_no');
            }
            $next_number = $this->codeExists($next_number);

            $code = $this->formattedCode($next_number);
        }
        return $code;
    }
    protected function codeExists($next_number)
    {
        $next_number = sprintf('%04d', $next_number);
        if ($this->whereCode($this->formattedCode($next_number))->count() > 0) {
            return $this->codeExists((int) $next_number + 1);
        }
        return $next_number;
    }

    protected function formattedCode($num)
    {
        if (!empty(get_option('ticket_number_format'))) {
            return get_option('ticket_prefix') . referenceFormatted(get_option('ticket_number_format'), $num);
        } else {
            return get_option('ticket_prefix') . sprintf('%04d', $num);
        }
    }

    public function assign()
    {
        return TicketAssigner::dispatch($this)->onQueue('high');
    }

    public function createTask()
    {
        $task = new Task;
        $task->project_id = request('project_id');
        $task->name = $this->subject;
        $task->description = $this->body;
        $task->start_date = now();
        $task->due_date = now()->addDays(config('system.task_due_after'))->format(config('system.preferred_date_format'));
        $task->hourly_rate = \Auth::user()->profile->hourly_rate;
        $task->user_id = \Auth::id();
        $task->save();
        foreach ($this->comments as $comment) {
            $comment->unsetEventDispatcher();
            $task->comments()->create(
                [
                    'parent' => $comment->parent,
                    'user_id' => \Auth::id(),
                    'message' => $comment->message,
                ]
            );
        }
        $this->files->each(
            function ($file) use ($task) {
                $task->files()->create(array_except($file->toArray(), 'id'));
            }
        );

        $task->assignees()->create(
            [
                'user_id' => \Auth::id(),
            ]
        );
        $task->tags()->sync($this->tags);
        return $task;
    }

    public function metaValue($key)
    {
        return optional($this->custom()->whereMetaKey($key)->first())->meta_value;
    }

    public function releaseTicket()
    {
        if (now()->diffInMinutes(dateParser($this->locked_time)) > 15) {
            $this->update(['is_locked' => 0, 'locked_by' => 0]);
        }
    }

    public function closeTicket()
    {
        $this->closed_at = now()->toDateTimeString();
        $this->closed_by = \Auth::check() ? \Auth::id() : firstAdminId();
        $this->status = Status::whereStatus('closed')->first()->id;
        $this->resolution_time = now()->diffInHours($this->created_at);
        $this->save();
        event(new TicketClosed($this, \Auth::id()));
    }
    // Reopen closed ticket
    public function openTicket()
    {
        $this->closed_at = null;
        $this->closed_by = 0;
        $this->status = Status::where('status', 'open')->first()->id;
        $this->resolution_time = 0;
        $this->save();
        event(new TicketOpened($this, \Auth::id()));
    }

    public function afterModelSaved()
    {
        $status = 'awaiting_agent';
        $lastCommentUser = optional($this->comments()->latest()->first())->user_id;
        if ($lastCommentUser != $this->user_id) {
            $status = 'awaiting_customer';
        }
        $this->response_status = $status;
        $this->saveQuietly();
        if (!\App::runningInConsole()) {
            \Artisan::call('analytics:tickets');
        }
    }

    public function isLocked()
    {
        return ($this->is_locked && $this->locked_by != \Auth::id()) ? true : false;
    }

    public function getNameAttribute()
    {
        return $this->subject;
    }
    /**
     * Scope a query to only include active tickets.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->whereNull('closed_at');
    }
    public function scopeClosed($query)
    {
        return $query->whereNotNull('closed_at');
    }
    public function getUrlAttribute()
    {
        return '/tickets/view/' . $this->id;
    }
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\TicketFactory::new();
    }
}
