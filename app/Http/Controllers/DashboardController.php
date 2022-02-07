<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index(){
        \Debugbar::info('DashboardController');

        \Debugbar::info(Auth::user()->getUserTeam()->display_name);

        return view('dashboard');
    }

    public function profile(){
        return view('profile');
    }
}
