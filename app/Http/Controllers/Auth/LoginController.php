<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Hautelook\Phpass\PasswordHash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Modules\Users\Entities\User;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public $maxAttempts  = 5;
    public $decayMinutes = 3;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['installed', 'guest'])->except('logout');
    }

    public function showLoginForm()
    {
        $ums_url = getenv('UMS_URL');
        $redirect_portal = Crypt::encryptString('pm');

        return redirect()->away($ums_url . 'login?redirect_portal=' . $redirect_portal);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function projectLogin(Request $request)
    {
        $email = Crypt::decryptString($request->get('email'));
        $password = urldecode($request->get('password'));

        //dd($password);
        //$password = Crypt::decryptString($password);
        
        if (Auth::attempt(['email' => $email , 'password' => $password])){
            //return redirect()->away($pm_url . 'projects/create');
            return redirect('/projects/create');
        }else{
            dd("failed login");
        }
    }

    public function login(Request $request)
    {
        $email = request()->get('email');
        $password = request()->get('password');
        
        $email = Crypt::decryptString($email);
        
        $myNewData = $request->request->add(['email' => $email, 'password' => $password]);
        
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request) || $this->oldLogin($request)) {
             return $this->sendLoginResponse($request);
        }
        

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function validateLogin(Request $request)
    {
        $rules                    = [];
        $rules[$this->username()] = 'required|string';
        $rules['password']        = 'required|string';
        if (get_option('use_recaptcha') === 'TRUE') {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }
        $this->validate($request, $rules);
        
    }

    /**
     * Attempt to log the user into the application using old credentials
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    public function oldLogin($request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user != null) {
            $passwordHasher = new PasswordHash(8, true);
            $passwordMatch  = $passwordHasher->CheckPassword($request->password, $user->password);
            if ($passwordMatch) {
                return Auth::login($user, true);
            }
        }
    }

    public function logout(Request $request)
    {
        //Logout on PM
        auth()->logout();

        //Do logout on ECOM
        if(url()->previous() !== getenv('ECOM_URL'))
        {
            $ecom_url = getenv('ECOM_URL');
            return redirect()->away($ecom_url . 'doEcomLogout');
        }

        //Do logout on UMS
        $ums_url = getenv('UMS_URL');
        $request_portal = Crypt::encryptString('pm');
        return redirect()->away($ums_url . 'signout?request_portal=' . $request_portal);
    }
}
