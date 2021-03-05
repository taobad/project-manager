<?php

namespace Modules\Calendar\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Calendar\Http\Requests\ReminderRequest;

class RemindersApiController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function save(ReminderRequest $request)
    {
        if (!isAdmin()) {
            $request->request->add(['recipient_id' => Auth::id()]);
        }
        $model = classByName($request->module)->findOrFail($request->module_id);
        $model->reminders()->create($request->except(['module', 'module_id', 'url']));
        $data['message'] = langapp('saved_successfully');
        $data['redirect'] = $request->url;

        return ajaxResponse($data, true, Response::HTTP_OK);
    }
}
