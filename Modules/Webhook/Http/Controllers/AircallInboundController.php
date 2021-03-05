<?php

namespace Modules\Webhook\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Deals\Entities\Deal;
use Modules\Leads\Entities\Lead;
use Modules\Users\Entities\Profile;

class AircallInboundController extends Controller
{
    /**
     * Receive callback POST from SMS
     *
     * @return Response
     */
    public function inbound(Request $request, $key = null)
    {
        if ($key != get_option('cron_key')) {
            return abort(401);
        }
        $lead = Lead::where('mobile', $this->format($request->data['raw_digits']))->first();
        // Search user with this number
        $profile = Profile::where('mobile', $this->format($request->data['raw_digits']))->first();
        // Call created
        if ($request->event == 'call.created') {
            if (isset($lead->id)) {
                $lead->notes()->create([
                    'name' => 'Call Created - ' . $lead->name,
                    'user_id' => $lead->sales_rep,
                    'description' => 'Call created for ' . $lead->name . ' to ' . $request->data['raw_digits'] . ' from ' . $request->data['number']['digits'],
                ]);
            }
            if (isset($profile->id)) {
                $deal = Deal::where('contact_person', $profile->user_id)->first();
                if (isset($deal->id)) {
                    $deal->notes()->create([
                        'name' => 'Call Created - ' . $deal->title,
                        'user_id' => $deal->user_id,
                        'description' => 'Call created for ' . $deal->title . ' to ' . $request->data['raw_digits'] . ' from ' . $request->data['number']['digits'],
                    ]);
                }
            }
        }
        // Call is answered
        if ($request->event == 'call.answered') {
            if (isset($lead->id)) {
                $lead->notes()->create([
                    'name' => 'Call Answered - ' . $lead->name,
                    'user_id' => $lead->sales_rep,
                    'description' => 'Call to ' . $request->data['raw_digits'] . ' from ' . $request->data['number']['digits'] . ' was answered by ' . $lead->name,
                ]);
            }
            if (isset($profile->id)) {
                $deal = Deal::where('contact_person', $profile->user_id)->first();
                if (isset($deal->id)) {
                    $deal->notes()->create([
                        'name' => 'Call Answered - ' . $deal->title,
                        'user_id' => $deal->user_id,
                        'description' => 'Call to ' . $request->data['raw_digits'] . ' from ' . $request->data['number']['digits'] . ' was answered by ' . $deal->contact->name,
                    ]);
                }
            }
        }
        // Call Hangup
        if ($request->event == 'call.hangup') {
            if (isset($lead->id)) {
                $lead->notes()->create([
                    'name' => 'Call Hangup - ' . $lead->name,
                    'user_id' => $lead->sales_rep,
                    'description' => 'Call to ' . $request->data['raw_digits'] . ' from ' . $request->data['number']['digits'] . ' was hangup',
                ]);
            }
            if (isset($profile->id)) {
                $deal = Deal::where('contact_person', $profile->user_id)->first();
                if (isset($deal->id)) {
                    $deal->notes()->create([
                        'name' => 'Call Hangup - ' . $deal->title,
                        'user_id' => $deal->user_id,
                        'description' => 'Call to ' . $request->data['raw_digits'] . ' from ' . $request->data['number']['digits'] . ' was hangup',
                    ]);
                }
            }
        }
        // Call ended
        if ($request->event == 'call.ended') {
            if (isset($lead->id)) {
                $this->saveLeadCallEnded($lead, $request);
            }
            if (isset($profile->id)) {
                $this->saveUserCallEnded($profile->user, $request);
            }
        }

        \Log::error($request->all());

        return ['message' => langapp('saved_successfully'), 'success' => true];
    }

    private function saveLeadCallEnded($lead, $request)
    {
        $call = $lead->calls()->create([
            'user_id' => $lead->sales_rep,
            'assignee' => $lead->sales_rep,
            'subject' => 'Call via Aircall.io',
            'duration' => $request->data['duration'],
            'type' => $request->data['direction'],
            'result' => 'Call conversation ' . $request->data['recording'],
            'description' => '',
            'recording' => $request->data['recording'],
            'started_at' => $request->data['started_at'],
            'ended_at' => $request->data['ended_at'],
        ]);
        foreach ($request->data['comments'] as $comment) {
            $call->comments()->create([
                'user_id' => $lead->sales_rep,
                'message' => 'Aircall Comment - ' . $comment['content'],
            ]);
        }
        foreach ($request->data['tags'] as $tag) {
            $call->tag($tag['name']);
        }
    }

    private function saveUserCallEnded($user, $request)
    {
        $deal = Deal::where('contact_person', $user->id)->first();
        if (isset($deal->id)) {
            $call = $deal->calls()->create([
                'user_id' => $deal->contact_person,
                'assignee' => $deal->user_id,
                'subject' => 'Call via Aircall.io',
                'duration' => $request->data['duration'],
                'type' => $request->data['direction'],
                'result' => 'Call conversation ' . $request->data['recording'],
                'description' => '',
                'recording' => $request->data['recording'],
                'started_at' => $request->data['started_at'],
                'ended_at' => $request->data['ended_at'],
            ]);
            foreach ($request->data['comments'] as $comment) {
                $call->comments()->create([
                    'user_id' => $deal->user_id,
                    'message' => 'Aircall Comment - ' . $comment['content'],
                ]);
            }
            foreach ($request->data['tags'] as $tag) {
                $call->tag($tag['name']);
            }
        } else {
            // Save call to user
            $call = $user->calls()->create([
                'user_id' => $user->id,
                'assignee' => firstAdminId(),
                'subject' => 'Call via Aircall.io',
                'duration' => $request->data['duration'],
                'type' => $request->data['direction'],
                'result' => 'Call conversation ' . $request->data['recording'],
                'description' => '',
                'recording' => $request->data['recording'],
                'started_at' => $request->data['started_at'],
                'ended_at' => $request->data['ended_at'],
            ]);
            foreach ($request->data['comments'] as $comment) {
                $call->comments()->create([
                    'user_id' => $user->id,
                    'message' => 'Aircall Comment - ' . $comment['content'],
                ]);
            }
            foreach ($request->data['tags'] as $tag) {
                $call->tag($tag['name']);
            }
        }
    }

    private function format($number)
    {
        return '+' . str_replace('+', '', str_replace(' ', '', $number));
    }
}
