<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    /**
     * Switch to the Profile view
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function profile(Request $request){
        \Debugbar::info('DashboardController@profile');
        \Debugbar::info($request->session()->token());
        \Debugbar::info(csrf_token());

        return view('profile');
    }
}
