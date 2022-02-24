<?php

namespace App\Http\Controllers;

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

        return view('users_table');
    }

    /**
     * Switch to the Measurements Table view
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function measurements_table(Request $request){
//        \Debugbar::info('DashboardController@profile');
//        \Debugbar::info($request->session()->token());
//        \Debugbar::info(csrf_token());

        return view('measurements_table');
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

        return view('bumblbees_table');
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

        return view('profile');
    }
}
