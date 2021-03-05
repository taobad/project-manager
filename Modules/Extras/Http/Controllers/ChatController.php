<?php

namespace Modules\Extras\Http\Controllers;

use App\Entities\Chat;
use App\Notifications\SMSContact;
use App\Notifications\WhatsappContact;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ChatController extends Controller
{
    /**
     * Request instance
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;
    /**
     * Chat model
     *
     * @var \App\Entities\Chat
     */
    protected $chat;

    public function __construct(Request $request, Chat $chat)
    {
        $this->middleware(['auth', 'verified', '2fa']);
        $this->request = $request;
        $this->chat    = $chat;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function send()
    {
        $this->request->validate(
            [
            'message' => 'required',
            'chatable_type' => 'required',
            'chatable_id' => 'required|numeric'
            ]
        );
        $model = classByName($this->request->chatable_type)->find($this->request->chatable_id);
        $chat = $model->chats()->create(
            [
            'user_id' => \Auth::id(),
            'inbound' => 0,
            'platform' => $this->request->has('is_sms') ? 'sms' : 'whatsapp',
            'message' => str_replace("{name}", $model->name, $this->request->message),
            'from' => $this->request->has('is_sms') ? env(strtoupper(get_option('sms_driver')).'_FROM') : get_option('whatsapp_number'),
            'to' => $model->mobile,
            'is_sms' => $this->request->has('is_sms') ? 1 : 0,
            ]
        );
        try {
            if ($this->request->has('is_sms')) {
                $model->notify(new SMSContact($chat));
            } else {
                $model->notify(new WhatsappContact($chat));
            }
            $message = $chat;
            $html = view('extras::_ajax.newChatHtml', compact('message'))->render();
            return response()->json(['status' => 'success', 'html' => $html, 'message' => langapp('sent_successfully')], 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Error', 'errors' => ['description' => [$exception->getMessage()]]], 500);
        }
    }

    public function delete()
    {
        if ($this->request->ajax()) {
            $chat = $this->chat->findOrFail($this->request->id);
            if (($chat->user_id == \Auth::id() || isAdmin()) && $chat->delete()) {
                return response()->json(['status' => 'success', 'message' => langapp('deleted_successfully')], 200);
            }

            return response()->json(['status' => 'errors', 'message' => 'something went wrong'], 401);
        }
    }
}
