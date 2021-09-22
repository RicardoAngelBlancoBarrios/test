<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class UserController extends Controller
{   
    public function login(Request $request) {
        if (Auth::check()) {
            return Redirect::to('/');
        } else {
            if ($request->isMethod('post')) {

                $userdata = array(
                    'name'     => $request->username,
                    'password' => $request->password
                );

                if (Auth::attempt($userdata)) {
			        $result['tittle']  = __('Bienvenid@'.' '.Auth::user()->full_name);
			        $result['type']    = __('success');
			        $result['message'] = __('');
        			return Redirect::to('/')->with('msg', $result)->withInput();
                } else {
                    $result['tittle']  = __('The following errors occurred:');
                    $result['type']    = __('error');
                    $result['message'] = __('Login Failure');

                    return Redirect::to('login')->with('msg', $result)->withInput();
                }
            } else {
				return view('users.login');
            }
        }
    }
    public function logOut() {
        Auth::logout();

        $result['tittle']  = __('');
        $result['type']    = __('info');
        $result['message'] = __('Your session has been closed');

        return Redirect::to('login')->with('msg', $result)->withInput();
    }
}
