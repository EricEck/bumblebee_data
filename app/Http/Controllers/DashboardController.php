<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index(Request $request){
        \Debugbar::info('DashboardController@Index');
        \Debugbar::info(Auth::user()->getUserTeam()->display_name);
        \Debugbar::info(csrf_token());
        return view('dashboard');
    }

    public function profile(Request $request){
        \Debugbar::info('DashboardController@profile');
        \Debugbar::info(Auth::user()->getUserTeam()->display_name);
        \Debugbar::info($request->session()->token());
        \Debugbar::info(csrf_token());



        return view('profile');
    }

    public function log_out(Request $request){
        \Debugbar::info('log out');
        \Debugbar::info(csrf_token());
        Auth::guard('web')->logout();
        \Debugbar::info(csrf_token());
//        Auth::guard('web')->logout();
        $request->session()->invalidate();
        \Debugbar::info(csrf_token());
        $request->session()->regenerateToken();
        \Debugbar::info(csrf_token());
        return view('welcome');
    }

    public function laratrust(Request $request){
        \Debugbar::info('DashboardController@laratrust');
        \Debugbar::info(Auth::user()->getUserTeam()->display_name);
        \Debugbar::info(csrf_token());
        return view('laratrust::panel.roles.show');
    }


}
