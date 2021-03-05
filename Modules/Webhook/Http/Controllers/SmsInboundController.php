<?php

namespace Modules\Webhook\Http\Controllers;

use App\Entities\Chat;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Leads\Entities\Lead;
use Modules\Users\Entities\Profile;

class SmsInboundController extends Controller
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
        // search for lead with this phone number
        $lead = Lead::where('mobile', $this->format($request->From))->first();
        // Search user with this number
        $profile = Profile::where('mobile', $this->format($request->From))->first();
        if ($request->SmsStatus == 'received') {
            if (isset($lead->id)) {
                $this->saveLeadSms($lead, $request);
            }
            if (isset($profile->id)) {
                $this->saveUserSms($profile->user, $request);
            }
        }

        if ($request->MessageStatus == 'delivered') {
            $chat = Chat::where(['to' => $request->To])->latest()->first();
            if (isset($chat->id)) {
                $chat->isDelivered();
                return ['message' => 'Message marked as delivered'];
            }
        }

        return ['message' => langapp('saved_successfully'), 'success' => true];
    }

    private function format($number)
    {
        return '+'.str_replace('+', '', $number);
    }

    private function saveLeadSms($lead, $request)
    {
        $lead->chats()->create(
            [
                'user_id' => $lead->sales_rep,
                'message' => $request->Body,
                'from' => $this->format($request->From),
                'to' => $request->To,
                'is_sms' => 1,
                'platform' => 'sms'
            ]
        );
        $lead->update(['has_chats' => 1]);
    }

    private function saveUserSms($user, $request)
    {
        $user->chats()->create(
            [
                'user_id' => $user->id,
                'message' => $request->Body,
                'from' => $this->format($request->From),
                'to' => $request->To,
                'is_sms' => 1,
                'platform' => 'sms'
            ]
        );
        $user->update(['has_chats' => 1]);
    }
}
