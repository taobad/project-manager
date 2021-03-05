<?php

namespace Modules\Milestones\Entities;

use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Milestones\Events\MilestoneCreated;
use Modules\Milestones\Events\MilestoneDeleted;
use Modules\Milestones\Events\MilestoneUpdated;
use Modules\Milestones\Scopes\MilestoneScope;
use Modules\Projects\Entities\Project;
use Modules\Tasks\Entities\Task;

class Milestone extends Model
{
    use Taggable, HasFactory;

    protected static $scope = MilestoneScope::class;

    protected $fillable = [
        'milestone_name', 'description', 'project_id', 'start_date', 'due_date',
    ];

    protected $appends = [
        'progress',
    ];
    protected $dates = [
        'due_date', 'start_date',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => MilestoneCreated::class,
        'updated' => MilestoneUpdated::class,
        'deleted' => MilestoneDeleted::class,
    ];

    public function AsProject()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Get milestone tasks.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'milestone_id')->with('user:id,username,name')->orderBy('id', 'desc');
    }

    public function getProgressAttribute()
    {
        return ceil($this->tasks()->avg('progress'));
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = dbDate($value);
    }
    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = dbDate($value);
    }
    public function getNameAttribute()
    {
        return $this->milestone_name;
    }
    public function getUrlAttribute()
    {
        return '/projects/view/' . $this->AsProject->id . '/milestones/' . $this->id;
    }
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\MilestoneFactory::new();
    }
}
