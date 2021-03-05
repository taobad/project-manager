<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cookie;

class Welcome extends Controller
{
    public function index(Request $request)
    {
        return redirect('dashboard');
    }

    public function acceptCurrency()
    {
        Cookie::make('acceptCurrency', 'true', 1440);
        return response(['message' => 'Base currency notification deactivated'], 200);
    }
    public function mg()
    {
        Artisan::call('migrate', ['--force' => true]);
        Artisan::call('view:clear');
        toastr()->success('Migrated successfully', langapp('response_status'));
        return redirect('dashboard');
    }
}
