<?php

namespace Modules\Webhook\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Leads\Entities\Lead;
use Modules\Users\Entities\Profile;
use Modules\Users\Entities\User;

class WhatsAppController extends Controller
{
    /**
     * Receive callback POST from nexmo
     *
     * @return Response
     */
    public function incoming(Request $request, $key = null)
    {
        if ($key != get_option('cron_key')) {
            return abort(401);
        }
        // $request = json_decode($request->data);
        // search for lead with this phone number
        $lead = Lead::where('mobile', $this->format($request->phone))->first();
        // Search user with this number
        $profile = Profile::where('mobile', $this->format($request->phone))->first();
        if (isset($lead->id)) {
            $this->saveLeadChat($lead, $request);
        }
        if (isset($profile->id)) {
            $this->saveUserChat($profile->user, $request);
        }
        return null;
    }

    private function format($number)
    {
        return '+' . str_replace('+', '', $number);
    }

    private function saveLeadChat($lead, $request)
    {
        $lead->chats()->create(
            [
                'user_id' => $lead->sales_rep,
                'message' => $request->message,
                'from'    => $this->format($request->phone),
                'to'      => $this->format($request->receiver),
            ]
        );
        $lead->update(['has_chats' => 1, 'whatsapp_optin' => 1]);
    }

    private function saveUserChat($user, $request)
    {
        $user->chats()->create(
            [
                'user_id' => $user->id,
                'message' => $request->message,
                'from'    => $this->format($request->phone),
                'to'      => $this->format($request->receiver),
            ]
        );
        $user->update(['has_chats' => 1, 'whatsapp_optin' => 1]);
    }
}
