<?php

namespace Modules\Users\Observers;

use Illuminate\Support\Facades\Storage;
use Modules\Clients\Entities\Client;
use Modules\Deals\Entities\Deal;
use Modules\Messages\Entities\Conversation;
use Modules\Projects\Entities\Project;
use Modules\Users\Entities\Profile;
use Modules\Users\Entities\User;
use Modules\Users\Entities\UserHasDepartment;
use Spatie\Permission\Models\Role;

class UserObserver
{
    /**
     * Listen to the User creating event.
     *
     * @param User $user
     */
    public function creating(User $user)
    {
        if (is_null($user->calendar_token)) {
            $user->calendar_token = str_random(60);
        }
        if (is_null($user->username)) {
            $user->username = $user->email;
        }
    }

    /**
     * Listen to the User created event.
     *
     * @param User $user
     */
    public function created(User $user)
    {
        $user->profile()->create(
            [
                'avatar' => null,
            ]
        );
        if (!$user->hasAnyRole(Role::all())) {
            $user->assignRole(get_option('default_role', 'client'));
        }
        if (is_null($user->access_token)) {
            $user->update(['access_token' => $user->createToken('Access Token')->accessToken]);
        }
    }

    /**
     * Listen to the User saved event.
     *
     * @param User $user
     */
    public function saved(User $user)
    {
        if (request()->has('tags')) {
            $user->retag(collect(request('tags'))->implode(','));
        }
        if (request()->has('department')) {
            UserHasDepartment::where('user_id', $user->id)->delete();
            if (request('department') != 0) {
                foreach (request('department') as $dept) {
                    $user->departments()->create(['department_id' => $dept]);
                }
            }
        }
    }

    /**
     * Listen to User deleting event.
     *
     * @param User $user
     */
    public function deleting(User $user)
    {
        foreach ($user->comments as $comment) {
            $comment->delete();
        }
        foreach ($user->feeds as $activity) {
            $activity->delete();
        }
        foreach ($user->tickets as $ticket) {
            $ticket->delete();
        }

        foreach ($user->messages() as $message) {
            $message->delete();
        }
        foreach ($user->uploads as $file) {
            $file->delete();
        }
        foreach ($user->timesheet as $tm) {
            $tm->delete();
        }
        foreach ($user->quickAccess as $shortcut) {
            $shortcut->delete();
        }
        foreach ($user->deals as $deal) {
            $deal->delete();
        }
        foreach ($user->issues as $issue) {
            $issue->delete();
        }
        foreach ($user->assignments as $assignee) {
            $assignee->delete();
        }
        foreach ($user->articles as $article) {
            $article->delete();
        }
        foreach ($user->announcements as $announcement) {
            $announcement->delete();
        }
        foreach ($user->expenses as $expense) {
            $expense->delete();
        }
        foreach ($user->leads as $lead) {
            $lead->delete();
        }
        foreach ($user->todos as $todo) {
            $todo->delete();
        }
        foreach ($user->appointments as $appointment) {
            $appointment->delete();
        }
        foreach ($user->schedules as $event) {
            $event->delete();
        }
        foreach ($user->cannedResponses as $response) {
            $response->delete();
        }
        foreach ($user->links as $link) {
            $link->delete();
        }
        foreach ($user->comments as $comment) {
            $comment->delete();
        }
        foreach ($user->signatures as $signature) {
            $signature->delete();
        }
        foreach ($user->feedbacks as $feedback) {
            $feedback->delete();
        }
        foreach ($user->vault as $v) {
            $v->delete();
        }
        foreach ($user->calls as $call) {
            $call->delete();
        }
        foreach ($user->departments as $dept) {
            $dept->delete();
        }
        Conversation::where('user_one', $user->id)->orWhere('user_two', $user->id)->delete();

        if (optional($user->profile)->avatar != 'default_avatar.png' && !isDemo()) {
            Storage::delete(config('system.avatar_dir') . '/' . optional($user->profile)->avatar);
        }

        Client::where('primary_contact', $user->id)->update(['primary_contact' => 0]);
        Deal::where('contact_person', $user->id)->update(['contact_person' => firstAdminId()]);
        Project::where('manager', $user->id)->update(['manager' => 0]);

        Profile::where('user_id', $user->id)->delete();
    }
}
