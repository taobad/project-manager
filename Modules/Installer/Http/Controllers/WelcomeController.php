<?php

namespace Modules\Installer\Http\Controllers;

use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{

    /**
     * Display the installer welcome page.
     *
     * @return \Illuminate\View\View
     */
    public function welcome()
    {
        return view('installer::welcome');
    }
}
