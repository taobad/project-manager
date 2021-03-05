<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class LoggedInDeviceController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa']);
    }

    /**
     * Display a listing of the currently logged in devices.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page'] = $this->getPage();
        $devices = \DB::table('sessions')
            ->where('user_id', \Auth::user()->id)
            ->get()->reverse();

        return view('users::logged_in_devices')
            ->with('devices', $devices)
            ->with($data)
            ->with('current_session_id', \Session::getId());
    }

    /**
     * Logout a session based on session id.
     *
     * @return \Illuminate\Http\Response
     */
    public function logoutDevice(Request $request, $device_id)
    {
        \DB::table('sessions')
            ->where('id', $device_id)->delete();

        return redirect('/users/logged-in-devices');
    }

    /**
     * Logouts a user from all other devices except the current one.
     *
     * @return \Illuminate\Http\Response
     */
    public function logoutAllDevices(Request $request)
    {
        \DB::table('sessions')
            ->where('user_id', \Auth::user()->id)
            ->where('id', '!=', \Session::getId())->delete();

        return redirect('/users/logged-in-devices');
    }

    private function getPage()
    {
        return langapp('profile');
    }
}
