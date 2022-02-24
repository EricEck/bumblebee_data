<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    //  Show all the users
    public function index(){
        return view('users.index');
    }

}
