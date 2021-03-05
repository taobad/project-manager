<?php

namespace Modules\Comments\Entities;

use App\Traits\BelongsToUser;
use App\Traits\Observable;
use App\Traits\Uploadable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Comments\Events\CommentCreated;
use Modules\Comments\Observers\CommentObserver;

class Comment extends Model
{
    use SoftDeletes, Observable, Uploadable, BelongsToUser, HasFactory;

    protected static $observer = CommentObserver::class;
    protected static $scope = null;

    protected $fillable = [
        'parent', 'user_id', 'message', 'unread', 'is_note', 'commentable_id', 'commentable_type', 'created_at',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => CommentCreated::class,
    ];

    /**
     * Get all of the owning commentable models.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent')->orderBy('id', 'desc');
    }

    public function markRead()
    {
        if ($this->user_id != \Auth::id()) {
            return $this->update(['unread' => 0]);
        }
    }

    public function notify()
    {
        $this->commentable->commentAlert($this);
    }

    public function isVisible()
    {
        if ($this->is_note === 1) {
            return \Auth::id() == $this->user_id || $this->commentable->isAgent();
        }
        return true;
    }

    /**
     * Check if user can download files
     *
     * @param  boolean $user The user id
     * @return boolean
     */
    public function canDownloadFiles($user = false)
    {
        return $this->commentable->canDownloadFiles($user);
    }

    public function scopeUnread($query)
    {
        return $query->whereUnread(1);
    }

    public function getMessageAttribute($value)
    {
        return $value;
        // return EmojiOne::toImage($value);
    }
    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\CommentFactory::new();
    }
}
