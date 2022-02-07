<?php

namespace App\Http\Controllers;

use App\Http\Controllers\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index(){
        \Debugbar::info('DashboardController');

        $userTeams = (new TeamController)->getUsersTeams(Auth::user());
        \Debugbar::info($userTeams[0]->display_name);


        return view('dashboard');
    }
}
