<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{

    /**
     * Export a list of Model Users to an Excel File
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
//    public function exportExcel(){
//        return Excel::download(new UsersExport('','id', 1),
//            'ellipticUsers.xlsx',
//            \Maatwebsite\Excel\Excel::XLSX);
//    }
//    public function exportCSV(){
//        return Excel::download(new UsersExport('', 'id', 1),
//            'ellipticUsers.csv',
//            \Maatwebsite\Excel\Excel::CSV,
//            ['Content-Type' => 'text/csv']);
//    }

    /**
     * Export a specific list of users
     *
     * parameters passed via Session and ->with() function
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportSearchExcel(){

        $searchString = \Session::get('searchString');
        $orderBy = \Session::get('orderBy');
        $orderAscending = \Session::get('orderAscending');

        return Excel::download(new UsersExport($searchString, $orderBy, $orderAscending),
            'ellipticUsers.xlsx',
            \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * Show the User Index View
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function indexView(){
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
