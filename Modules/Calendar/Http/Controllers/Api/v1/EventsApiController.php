<?php

namespace Modules\Calendar\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Calendar\Entities\Calendar;
use Modules\Calendar\Http\Requests\CalendarRequest;

class EventsApiController extends Controller
{
    protected $request;
    protected $calendar;

    public function __construct(Request $request)
    {
        $this->request  = $request;
        $this->calendar = new Calendar;
    }

    public function save(CalendarRequest $request)
    {
        $request->request->add(['start_date' => dateParser($request->start_date, null, true)]);
        $request->request->add(['end_date' => dateParser($request->end_date, null, true)]);
        if ($request->module === 'events') {
            $this->calendar->create($request->all());
        } else {
            $model = classByName($request->module)->findOrFail($request->module_id);
            $model->schedules()->create($request->all());
        }

        $data['message']  = langapp('saved_successfully');
        $data['redirect'] = $request->redirect;

        return ajaxResponse($data, true, Response::HTTP_OK);
    }

    public function update(CalendarRequest $request, $id = null)
    {
        $request->request->add(['start_date' => dateParser($request->start_date, null, true)]);
        $request->request->add(['end_date' => dateParser($request->end_date, null, true)]);
        
        $event = $this->calendar->findOrFail($id);
        if (!$request->has('deleted')) {
            $event->update($request->except(['id', 'eventable_type', 'eventable_id', 'user_id', 'deleted']));
        } else {
            $event->delete();
        }
        $data['message']  = langapp('changes_saved_successful');
        $data['redirect'] = $request->redirect;

        return ajaxResponse($data, true, Response::HTTP_OK);
    }
}
