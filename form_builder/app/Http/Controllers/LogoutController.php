<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\User;
use Middleware\RedirectIfAuthenticated;

class LogoutController extends Controller
{

    
     /**
     * Log out account user.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function logout()
    {
        $userObj = new User();
        Session::flush();            
        Auth::logout();     
        return redirect('/');
       
    }
}
