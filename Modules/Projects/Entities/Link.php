<?php

namespace Modules\Projects\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Projects\Entities\Project;

class Link extends Model
{
    protected $fillable = [
        'project_id', 'client_id', 'icon', 'title', 'url', 'description',
        'username', 'password', 'user_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function setUserIdAttribute($value)
    {
        $this->attributes['user_id'] = \Auth::id();
    }
}
