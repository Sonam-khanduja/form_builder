<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;


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

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $userModelObj = new User();    
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials) ) {    
            $userId = auth()->user()->id;        
            $userModelObj ->userSessionDestroyOtherDevice($userId);     
            
           if(Auth::user()->status == 1){
                auth()->user()->generateCode();
                return redirect()->route('2fa.index');
            }else if(Auth::user()->status == 0) {
                Auth::logout();
                return redirect("login")->withSuccess('User is inactive. Please contact to Administartor!');
            }
            else{
                return redirect()->route('home');
            }
        }else{
            return redirect("login")->withSuccess('Login details are not valid');
        }
  
    }


       
}
