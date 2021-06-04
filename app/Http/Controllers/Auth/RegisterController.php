<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Clients\Entities\Client;
use Modules\Users\Entities\User;

use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
        // if (!settingEnabled('allow_client_registration')) {
        //     $this->middleware('auth');
        // }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'agree_terms' => 'accepted',
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return \Modules\Users\Entities\User
     */
    protected function create(array $data)
    {
        $user = User::create(
            [
                'username' => $data['email'],
                'email' => $data['email'],
                'name' => $data['name'],
                'password' => $data['password'],
                'email_verified_at' => config('system.verification') ? null : now(),
            ]
        );
        $user->profile->update(
            [
                'company' => Client::firstOrCreate(
                    ['email' => $data['company_email']],
                    ['name' => $data['company'], 'primary_contact' => $user->id]
                )->id,
                'mobile' => $data['mobile'],
            ]
        );
        return $user;
    }

    protected function registered(Request $request, $user)
    {
        // $user->generateToken();
        // $user->sendEmailVerificationNotification();
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {

        $response = Http::get('http://sso.lupinga.local/api/test');
        var_dump($response);
        
        //$response = Http::get('http://sso.lupinga.local/api/test');
        /*$curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://sso.lupinga.local/api/test',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        var_dump($response);
        echo "Test";*/

        die;

       /* $response = Http::post('http://sso.lupinga.local/api/login', [
            'name' => 'admin@demo.com',
            'password' => '123456',
        ]);  */   
        
        /*$curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://sso.lupinga.local/api/login',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('email' => 'admin@demo.com','password' => '123456'),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;*/

        print_r($response);exit;

        $this->validator($request->all())->validate();

        if (config('system.secure_password')) {
            $request->validate(['password' => 'pwned']);
        }

        
        $user = $this->create($request->all());

        event(new Registered($user));

        $this->guard()->login($user);

        // update sso-api user table
        

        return $this->registered($request, $user)
        ?: redirect($this->redirectPath());
    }
}
