<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Configuration;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        if(\App::isLocale('ka')){

            $message = array(
                'firstname.required' => 'სახელი აუცილებელია',
                'lastname.required' => 'გვარი აუცილებელია',
                'email.required' => 'ელ-ფოსტა აუცილებელია',
                'password.required' => 'პაროლი აუცილებელია',
                'g-recaptcha-response.required' => 'გთხოვთ შეამოწმეთ recaptcha'
            );

        } else {

            $message = array(
                'g-recaptcha-response.required' => 'Please check recaptcha',
            );

        }

        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'g-recaptcha-response' => 'required',
        ], $message);
    }



    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $captcha = $data['g-recaptcha-response'] ;
        $secret = '6LfwuN8ZAAAAAFd7sP7pDDPKRG-4hYnGzi6XEKyM';
        $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);

        if($response['success'] == false)
        {
            return back()->with('alert_false', "You are spammer!!!");
        }


        $group_role = "user";

        return User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'firstname_en' => $data['firstname'],
            'lastname_en' => $data['lastname'],
            'email' => $data['email'],
            'group_role' => "user",
            'password' => Hash::make($data['password']),
        ]);


    }

    public function showRegistrationForm()
    {
        $configuration = Configuration::find(1);
        return view('auth.register', compact( "configuration" ));
    }
}
