<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
//use http\Client\Curl\User;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public  function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }
    public function  handelGoogleCallback(){
        $user=Socialite::driver('google')->user();
$this->_registerOrLoginUSer($user);
return redirect()->route('home');

    }

    public  function redirectToFacebook(){
        return Socialite::driver('facebook')->redirect();
    }
    public function  handelFacebookCallback(){
        $user=Socialite::driver('facebook')->user();
        $this->_registerOrLoginUSer($user);
        return redirect()->route('home');

    }
    protected function _registerOrLoginUSer($data){
        $user=User::where('email','=',$data->email)->first();
        if (!$user){
            $user=new User();
            $user->name=$data->name;
            $user->email=$data->email;
            $user->provider_id=$data->id;
            $user->avatar=$data->avatar;
            $user->avatar=$data->avatar;
            $user->save();
        }
        Auth::login($user);
    }
}
