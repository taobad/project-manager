<?php

namespace Modules\Updates\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Modules\Updates\Jobs\UpdateSystemJob;

class UpdatesController extends Controller
{
    public function schedule()
    {
        $data['current_timezone'] = get_option('timezone');
        return view('updates::modal.schedule_update')->with($data);
    }

    public function backup()
    {
        if (!isAdmin()) {
            abort(403);
        }
        Artisan::queue('backup:run');
        return ajaxResponse(
            [
                'message' => 'Backup request initialized check folder /storage/app/' . config('app.name'),
                'redirect' => url()->previous(),
            ],
            true,
            Response::HTTP_OK
        );
    }

    public function check()
    {
        if (!isAdmin()) {
            abort(403);
        }
        Artisan::queue('app:updates');
        return ajaxResponse(
            [
                'message' => 'You will receive an email when an update is available',
                'redirect' => url()->previous(),
            ],
            true,
            Response::HTTP_OK
        );
    }

    public function install()
    {
        if (!isAdmin()) {
            abort(403);
        }
        if (is_null(getLastVersion())) {
            return ajaxResponse(['message' => 'No updates found!', 'redirect' => url()->previous()], true, 500);
        }
        UpdateSystemJob::dispatch(Auth::id());
        toastr()->info('Update installed successfully.', langapp('response_status'));
        return ajaxResponse(
            [
                'message' => 'Completed',
                'redirect' => url()->previous(),
            ],
            true,
            Response::HTTP_OK
        );
    }

    public function scheduleUpdate(Request $request)
    {
        if (!isAdmin()) {
            abort(403);
        }
        $request->validate(
            [
                'start_time' => 'required',
                'timezone' => 'required',
            ]
        );
        date_default_timezone_set($request->timezone);
        $request->request->add(['start_time' => dateParser($request->start_time, $request->timezone, true)]);
        $request->validate(['start_time' => 'after:now']);
        UpdateSystemJob::dispatch(Auth::id())->onQueue('high')->delay($request->start_time);
        toastr()->info('An email will be sent to ' . Auth::user()->email . ' when completed', langapp('response_status'));
        return ajaxResponse(
            [
                'message' => 'Update scheduled successfully',
                'redirect' => url()->previous(),
            ],
            true,
            Response::HTTP_OK
        );
    }
}
