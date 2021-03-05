<?php

namespace Modules\Calendar\Http\Controllers\Api\v1;

use App\Traits\AjaxResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Calendar\Entities\Appointment;
use Modules\Calendar\Http\Requests\AppointmentRequest;

class AppointmentApiController extends Controller
{
    use AjaxResponse;

    protected $request;
    protected $appointment;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->appointment = new Appointment;
    }

    public function save(AppointmentRequest $request)
    {
        try {
            $this->appointment->create($request->all());
            $data['message'] = langapp('saved_successfully');
            $data['redirect'] = $request->url;
            return $this->success($data);
        } catch (\Throwable $th) {
            $data['errors'] = [$th->getMessage()];
            return $this->failure($data);
        }
    }

    public function update(AppointmentRequest $request, $id = null)
    {
        $appointment = $this->appointment->findOrFail($id);
        if (!$request->has('deleted')) {
            $appointment->update($request->except(['id', 'user_id', 'deleted']));
        } else {
            $appointment->delete();
        }
        $data['message'] = langapp('changes_saved_successful');
        $data['redirect'] = $request->url;

        return ajaxResponse($data, true, Response::HTTP_OK);
    }
}
