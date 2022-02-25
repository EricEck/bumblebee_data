<?php

namespace App\Http\Controllers;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    /**
     * Switch to Dashboard view
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function dashboard(Request $request){
        \Debugbar::info('DashboardController@Index');
        \Debugbar::info(csrf_token());
        return view('dashboard');
    }

    /**
     * Switch to the Users Table view
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function users_table(Request $request){
//        \Debugbar::info('DashboardController@profile');
//        \Debugbar::info($request->session()->token());
//        \Debugbar::info(csrf_token());

        Debugbar::info('users_table');
        return view('users.index');
    }

    /**
     * Switch to the Measurements Table view old way
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function measurements_table_old(Request $request){
//        \Debugbar::info('DashboardController@profile');
//        \Debugbar::info($request->session()->token());
//        \Debugbar::info(csrf_token());

        return view('dashboard');   // fix this later or remove the whole method TODO
    }

    /**
     * Switch to the Bumblebees Table view
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function bumblebees_table(Request $request){
//        \Debugbar::info('DashboardController@profile');
//        \Debugbar::info($request->session()->token());
//        \Debugbar::info(csrf_token());

        return view('dashboard');   // todo: change or delete whole method
    }

    /**
     * Switch to the Profile view
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function profile(Request $request){
//        \Debugbar::info('DashboardController@profile');
//        \Debugbar::info($request->session()->token());
//        \Debugbar::info(csrf_token());

        return view('users.profile');
    }
}
