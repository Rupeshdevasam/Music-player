<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Redirect;


class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        //error_log($request['email']);
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            //return "true";
            //
            return view('welcome');
  
            return "true";
        }
        else
        {
        	return "false";
        }
    }

    public function getSignOut() {
	
	console.log("");	
	Auth::logout();
	return Redirect::route('home');
	
	}
}
