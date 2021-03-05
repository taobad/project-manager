<?php

namespace App\Http\Controllers;

use App\Notifications\WhatsAppSubscribe;
use Auth;
use Illuminate\Http\Request;

class WhatsAppSubscribeController extends Controller
{
    public function form()
    {
        return view('modal.whatsapp_subscribe');
    }

    public function subscribe(Request $request)
    {
        $request->validate(['mobile' => 'required|string|max:255']);
        Auth::user()->profile->update(['mobile' => $request->mobile]);
        Auth::user()->notify(new WhatsAppSubscribe($request->mobile));
        $data['message'] = langapp('whatsapp_subscribe_text_sent');
        $data['redirect'] = url()->previous();
        return ajaxResponse($data);
    }
}
