<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    //
    //  Show all the users
    public function index(){
        return view('users.index');
    }

    /**
     * Render the User Info Form with Editing
     * @param $user_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function userFormEdit($user_id){

        $user = User::where('id', $user_id)->first();

        return view('users.user_form', [
            'allow_edit' => true,
            'user' => $user,
        ]);
    }

    /**
     * Render the User Info Form No Edit
     * @param $user_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function userFormShow($user_id){

        $user = User::where('id', $user_id)->first();

        return view('users.user_form', [
            'allow_edit' => false,
            'user' => $user,
        ]);
    }

}
