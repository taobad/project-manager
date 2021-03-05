<?php

namespace Modules\Projects\Entities;

use App\Traits\Actionable;
use App\Traits\Assignable;
use App\Traits\Commentable;
use App\Traits\Customizable;
use App\Traits\Eventable;
use App\Traits\Observable;
use App\Traits\Remindable;
use App\Traits\Reviewable;
use App\Traits\Searchable;
use App\Traits\Taggable;
use App\Traits\Timeable;
use App\Traits\Todoable;
use App\Traits\Uploadable;
use App\Traits\Vaultable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Clients\Entities\Client;
use Modules\Contracts\Entities\Contract;
use Modules\Deals\Entities\Deal;
use Modules\Expenses\Entities\Expense;
use Modules\Invoices\Entities\Invoice;
use Modules\Issues\Entities\Issue;
use Modules\Items\Services\TaxCalculator;
use Modules\Milestones\Entities\Milestone;
use Modules\Projects\Entities\Link;
use Modules\Projects\Events\ProjectCreated;
use Modules\Projects\Events\ProjectDeleted;
use Modules\Projects\Events\ProjectUpdated;
use Modules\Projects\Notifications\ProjectCommented;
use Modules\Projects\Observers\ProjectObserver;
use Modules\Projects\Scopes\ProjectScope;
use Modules\Projects\Services\ProjectRate;
use Modules\Projects\Services\ProjectRateFactory;
use Modules\Tasks\Entities\Task;
use Modules\Tickets\Entities\Ticket;
use Modules\Users\Entities\QuickAccess;

class Project extends Model
{
    use Actionable, Commentable, Assignable, Taggable, Vaultable, Customizable, HasFactory,
    Todoable, Observable, Uploadable, Eventable, Remindable, Timeable, Reviewable, Searchable;

    protected static $observer = ProjectObserver::class;
    protected static $scope = ProjectScope::class;

    protected $fillable = [
        'code', 'description', 'name', 'client_id', 'currency', 'start_date', 'due_date', 'hourly_rate', 'fixed_price',
        'progress', 'notes', 'manager', 'status', 'auto_progress', 'estimate_hours', 'settings', 'alert_overdue',
        'used_budget', 'billable_time', 'unbillable_time', 'unbilled', 'sub_total', 'total_expenses', 'todo_percent',
        'contract_id', 'billing_method', 'archived_at', 'token', 'rated', 'overbudget_at', 'feedback_disabled', 'created_at',
        'is_template', 'deal_id', 'icon',
    ];
    protected $casts = [
        'settings' => 'array',
        'progress' => 'integer',
        'currency' => 'string',
    ];

    protected $dates = [
        'start_date',
    ];

    protected $appends = [
        'timer_on',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ProjectCreated::class,
        'updated' => ProjectUpdated::class,
        'deleted' => ProjectDeleted::class,
    ];

    /**
     * Get project tasks relations.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id')->with('user:id,username')->orderBy('id', 'desc');
    }

    /**
     * Get project milestones relations.
     */
    public function milestones()
    {
        return $this->hasMany(Milestone::class, 'project_id');
    }

    /**
     * Get project issues relations.
     */
    public function issues()
    {
        return $this->hasMany(Issue::class, 'project_id')->orderByDesc('id');
    }

    /**
     * Get project expenses relations.
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'project_id')->orderBy('id', 'desc');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'project_id')->orderBy('id', 'desc');
    }

    /**
     * Get project links relations.
     */
    public function links()
    {
        return $this->hasMany(Link::class, 'project_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'project_id');
    }

    public function company()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    /**
     * Deal attached to project
     */
    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function sidebars()
    {
        return $this->hasMany(QuickAccess::class, 'project_id')->where('user_id', \Auth::id());
    }

    public function isClient()
    {
        return Auth::user()->profile->company === $this->client_id ? true : false;
    }

    public function usedBudget()
    {
        return $this->estimate_hours > 0 ? formatDecimal((toHours($this->billable_time) / $this->estimate_hours) * 100) : 0;
    }

    public function cost()
    {
        $calc = (new ProjectRate(new ProjectRateFactory()));
        return $calc->setType($this->billing_method)->calculateCost($this);
    }

    public function commentAlert($comment)
    {
        $members = $this->assignees->filter(
            function ($member) {
                return $member->user_id != \Auth::id();
            }
        );
        \Notification::send($members->pluck('user'), new ProjectCommented($this));
    }
    /**
     * Computes project totals and costs
     */
    public function afterModelSaved()
    {
        $this->unbilled = $this->unbilled();
        $this->billable_time = $this->billable();
        $this->unbillable_time = $this->unbillable();
        $this->total_expenses = $this->totalExpenses();
        $this->sub_total = $this->cost();
        $this->used_budget = $this->usedBudget();
        $this->progress = $this->calcProgress();
        $this->saveQuietly();
        $this->tasks->each(
            function ($task) {
                $task->afterModelSaved();
            }
        );
        if (!\App::runningInConsole()) {
            \Artisan::call('analytics:projects');
            \Artisan::call('analytics:tasks');
        }
    }
    /**
     * Total amount of billable time
     *
     * @return float|int
     */
    public function billable()
    {
        $total = 0;
        foreach ($this->timesheets->where('billable', 1) as $time) {
            $total += $time->worked;
        }
        return $total;
    }
    /**
     * Total amount of unbillable time
     *
     * @return float|int
     */
    public function unbillable()
    {
        $total = 0;
        foreach ($this->timesheets->where('billable', 0) as $time) {
            $total += $time->worked;
        }
        return $total;
    }
    /**
     * Download project PDF
     *
     * @param boolean $download browser download or save to disk
     */
    public function pdf($download = true)
    {
        return (new \App\Helpers\PDFEngine('projects', $this, $download))->pdf();
    }
    /**
     * Total amount of unbilled time
     *
     * @return float|int
     */
    public function unbilled()
    {
        $total = 0;
        foreach ($this->timesheets->where('billable', 1)->where('billed', 0) as $time) {
            $total += $time->worked;
        }
        return $total;
    }
    /**
     * Gets the total amount of pending expenses
     *
     * @return float|int
     */
    public function pendingExpenses()
    {
        $total = 0;
        foreach ($this->expenses()->billable()->unbilled()->get() as $expense) {
            if ($expense->currency != $this->currency) {
                $total += convertCurrency($expense->currency, $expense->cost, $this->currency);
            } else {
                $total += $expense->cost;
            }
        }
        return $total;
    }
    /**
     * Gets the total amount of project expenses
     *
     * @return float|int
     */
    public function totalExpenses()
    {
        $total = 0;
        foreach ($this->expenses as $expense) {
            if ($expense->currency != $this->currency) {
                $total += convertCurrency($expense->currency, $expense->cost, $this->currency);
            } else {
                $total += $expense->cost;
            }
        }
        return $total;
    }
    /**
     * Calculate project progress
     *
     * @return float|int
     */
    public function calcProgress()
    {
        if ($this->auto_progress) {
            return $this->tasks()->avg('progress');
        }
        return $this->progress;
    }

    public function metaValue($key)
    {
        return optional($this->custom()->whereMetaKey($key)->first())->meta_value;
    }
    /**
     * Check if setting enabled
     *
     * @param  string $setting
     * @return boolean
     */
    public function setting($setting)
    {
        return array_key_exists($setting, (array) $this->settings) ? true : false;
    }
    /**
     * Add project to sidebar
     */
    public function addSidebar()
    {
        if (QuickAccess::where(['project_id' => $this->id, 'user_id' => \Auth::id()])->count() > 0) {
            QuickAccess::where(['project_id' => $this->id, 'user_id' => \Auth::id()])->delete();
        } else {
            $this->sidebars()->updateOrCreate(
                ['user_id' => \Auth::id(), 'project_id' => $this->id],
                ['task_id' => null]
            );
        }
    }
    /**
     * Percentage number of completed tasks
     *
     * @return float|int
     */
    public function taskDonePercent()
    {
        return count($this->tasks) ? (count($this->tasks->where('progress', 100)) / count($this->tasks)) * 100 : 0;
    }
    /**
     * Percentage number of invoiced expenses
     *
     * @return float|int
     */
    public function expensesPercent()
    {
        return $this->expenses->count() ? ($this->expenses->where('invoiced', 1)->count() / $this->expenses->count()) * 100 : 0;
    }
    /**
     * Create an invoice using specified items style
     *
     * @param  string $invoiceStyle How line items will be displayed
     * @return object $invoice
     */
    public function makeInvoice($invoiceStyle = 'task_line')
    {
        $invoice = new Invoice();
        $invoice->reference_no = generateCode('invoices');
        $invoice->client_id = $this->client_id;
        $invoice->currency = $this->currency;
        $invoice->due_date = incrementDate(now(), get_option('invoices_due_after'));
        $invoice->notes = get_option('default_terms');
        $invoice->project_id = $this->id;
        $invoice->gateways = [
            'paypal' => true,
            'bank' => true,
        ];
        $invoice->tax_per_item = settingEnabled('show_invoice_tax') ? 1 : 0;
        $invoice->tax_types = json_decode(get_option('default_tax_rates'));
        $invoice->save();

        $unBilledTimers = $this->timesheets()->where(['billable' => 1, 'is_started' => 0, 'billed' => 0])->get();

        if ($invoiceStyle === 'single') {
            $taskList = [];

            foreach ($unBilledTimers as $timer) {
                $taskList[] = $timer->timeable->name . ' - ' . secToHours($timer->worked);
            }
            $invoice->items()->create(
                [
                    'name' => $this->name,
                    'description' => '[' . secToHours($this->billable_time) . ']  ' . PHP_EOL . implode('  ' . PHP_EOL, $taskList),
                    'unit_cost' => $this->cost(),
                    'quantity' => 1,
                ]
            );
            $this->timesheets()->update(['billed' => 1]);
        } else {
            foreach ($unBilledTimers as $entry) {
                $invoice->items()->create(
                    [
                        'name' => '[' . $this->name . ']',
                        'description' => $entry->task_id > 0 ? $entry->task->name : $entry->timeable->name,
                        'unit_cost' => $this->billing_method == 'hourly_project_rate' ? $this->hourly_rate : (($entry->task_id > 0) ? optional($entry->task)->hourly_rate : optional($entry->timeable)->hourly_rate),
                        'quantity' => toHours($entry->worked),
                    ]
                );
                $entry->update(['billed' => 1]);
            }
        }
        $expenses = request()->has('expense') ? array_keys(request('expense')) : array_pluck($this->expenses()->billable()->unbilled()->get()->toArray(), 'id');

        foreach ($expenses as $val) {
            $expense = Expense::findOrFail($val);
            $invoice->items()->create(
                [
                    'name' => langapp('expenses'),
                    'description' => '[' . $expense->AsCategory->name . ']  ' . PHP_EOL . '&raquo; ' . $expense->expense_date->toDayDateTimeString() . PHP_EOL . $expense->notes,
                    'unit_cost' => $expense->cost,
                    'quantity' => 1,
                    'total_cost' => $expense->cost * 1,
                ]
            );
            $expense->update(['invoiced' => 1, 'invoiced_id' => $invoice->id]);
        }
        foreach ($invoice->items as $item) {
            (new TaxCalculator($invoice, $item, $invoice->tax_types))->saveTaxes();
        }
        $invoice->updateAddresses();

        return $invoice;
    }

    public function ganttData($type = 'milestones', $taskStatus = null)
    {
        $type_data = [];
        if ($type == 'milestones') {
            $type_data[] = [
                'name' => langapp('uncategorized'),
                'dep_id' => 'milestone_0',
                'start' => now()->toDateString(),
                'end' => now()->addDays(30)->toDateString(),
                'id' => 0,
                'progress' => 0,
                'project' => $this->id,
                'dependencies' => [],
            ];
            foreach ($this->milestones->toArray() as $m) {
                $m['dep_id'] = 'milestone_' . $m['id'];
                $m['milestone_id'] = $m['id'];
                $m['name'] = $m['milestone_name'];
                $m['start'] = Carbon::parse($m['start_date'])->toDateString();
                $m['end'] = Carbon::parse($m['due_date'])->toDateString();
                $m['project'] = $m['project_id'];
                $m['dependencies'] = [];
                $type_data[] = $m;
            }
        }
        $gantt_data = [];
        foreach ($type_data as $data) {
            if ($type == 'milestones') {
                $tasks = $this->tasks->where('milestone_id', $data['id'])->toArray();
                if (isset($data['due_date'])) {
                    $data['end'] = Carbon::parse($data['due_date'])->toDateString();
                }
                unset($data['description']);
            }
            if (count($tasks) > 0) {
                $data['id'] = $data['dep_id'];
                $data['start'] = $data['start'];
                $data['project'] = $this->id;
                $data['end'] = (isset($data['end'])) ? $data['end'] : $this->due_date;
                unset($data['dep_id']);
                $gantt_data[] = $data;

                foreach ($tasks as $task) {
                    $gantt_data[] = prepareGanttData($task, $data['id']);
                }
            }
        }

        return $gantt_data;
    }

    /**
     * Check if the time is running
     *
     * @return int
     */
    public function timerRunning()
    {
        return $this->timesheets()->where('user_id', \Auth::id())->whereNull('task_id')->running()->count();
    }
    /**
     * Start project timer
     *
     * @return boolean
     */
    public function startClock()
    {
        $entry = $this->timesheets()->running()->where('user_id', \Auth::id());
        if ($entry->count() === 0) {
            $this->timesheets()->create(
                [
                    'is_started' => 1,
                    'user_id' => \Auth::id(),
                    'started_by' => \Auth::id(),
                    'start' => now()->timestamp,
                ]
            );

            return true;
        }
        return false;
    }
    /**
     * Stop project timer
     */
    public function stopClock()
    {
        $timer = $this->timesheets()->whereUserId(\Auth::id())->running()->first();
        if (!isset($timer->id)) {
            return false;
        }
        return $timer->update(['end' => now()->timestamp, 'is_started' => 0, 'started_by' => 0]);
    }
    /**
     * Amount of billed expenses
     *
     * @return float|string
     */
    public function billedExpenses()
    {
        $total = 0;
        foreach ($this->expenses->where('invoiced', 1) as $expense) {
            if ($expense->currency != $this->currency) {
                $total += convertCurrency($expense->currency, $expense->cost, $this->currency);
            } else {
                $total += $expense->cost;
            }
        }

        return formatDecimal($total);
    }
    /**
     * Get the next project code in sequence
     *
     * @return string
     */
    public function nextCode()
    {
        $code = sprintf('%04d', 1);
        $max = $this->withoutGlobalScopes()->whereNotNull('code')->max('id');
        if ($max > 0) {
            $row = $this->withoutGlobalScopes()->find($max);
            $ref_number = intval(substr($row->code, -4));
            $next_number = $ref_number + 1;
            if ($next_number < 1) {
                $next_number = 1;
            }
            $next_number = $this->codeExists($next_number);
            $code = sprintf('%04d', $next_number);
        }
        return get_option('project_prefix') . $code;
    }
    /**
     * Check if the code exists in projects table
     */
    public function codeExists($next_number)
    {
        $next_number = sprintf('%04d', $next_number);
        if ($this->withoutGlobalScopes()->where('code', get_option('project_prefix') . $next_number)->count() > 0) {
            return $this->codeExists((int) $next_number + 1);
        }
        return $next_number;
    }
    /**
     * Check if project is overdue
     *
     * @return boolean
     */
    public function isOverdue()
    {
        if (strtotime($this->due_date) < time() && strtotime($this->due_date) > 0 && $this->progress < 100) {
            return true;
        }

        return false;
    }
    /**
     * Check if a user is a team member
     *
     * @param  boolean $user The user id
     * @return boolean
     */
    public function isTeam($user = false)
    {
        return in_array($user ? $user : \Auth::id(), array_pluck($this->assignees->toArray(), 'user_id'));
    }
    /**
     * Check if user can download files
     *
     * @param  boolean $user The user id
     * @return boolean
     */
    public function canDownloadFiles($user = false)
    {
        return $this->isClient() || $this->isTeam();
    }
    /**
     * Retrieve list of active projects
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Active')->whereNull('archived_at');
    }
    /**
     * Get completed projects
     */
    public function scopeDone($query)
    {
        return $query->where('progress', 100)->whereNull('archived_at');
    }
    /**
     * Parse and set the start date
     */
    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = dbDate($value);
    }
    /**
     * Parse and set the project due date
     */
    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = dbDate($value);
    }

    public function getTimerOnAttribute()
    {
        return $this->timerRunning();
    }

    public function getTextColorAttribute()
    {
        if ($this->used_budget > 100) {
            return 'danger';
        }
        if ($this->progress == 100) {
            return 'success';
        }
        if ($this->progress == 0) {
            return 'warning';
        }
        return 'primary';
    }
    public function ribbonColor()
    {
        switch ($this->getRawOriginal('status')) {
            case 'Done':
                return 'success';
                break;
            case 'On Hold':
                return 'red';
                break;
            case 'Active':
                return 'info';
                break;
            default:
                return 'gray';
                break;
        }
    }
    public function getUnbilledExpensesAttribute()
    {
        return $this->pendingExpenses();
    }
    public function getBilledExpensesAttribute()
    {
        return $this->billedExpenses();
    }

    public function getSettingsAttribute($value)
    {
        return is_null($value) ? [] : json_decode($value);
    }
    public function getUrlAttribute()
    {
        return '/projects/view/' . $this->id;
    }
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\ProjectFactory::new ();
    }
}
