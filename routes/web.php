<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Remove this when done with power grid
Route::view('/powergrid', 'powergrid-demo');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/token', function (Request $request) {
//    $token = $request->session()->token();
//    Debugbar::info($token);
    Debugbar::info(csrf_token());
    return view('welcome');

});

/**
 * Only Authorized Users
 */
Route::group(['middleware' => ['auth']], function (){

    // throws a warning on Str::
    Route::get('/profile',
        [   'middleware'    => ['permission:profile-read'],
            'uses'          => 'App\Http\Controllers\DashboardController@profile'])
        ->name('profile');

//    Route::get('/users_table', 'App\Http\Controllers\DashboardController@users_table')
//        ->name('users_table');

    Route::get('/users_table', [UserController::class, 'index'])->name('users_table');

    Route::get('/user_form/edit/{user_id}', [UserController::class, 'userFormEdit']);
    Route::get('/user_form/show/{user_id}', [UserController::class, 'userFormShow']);

    Route::get('/bumblebees_table', 'App\Http\Controllers\DashboardController@bumblebees_table')
        ->name('bumblebees_table');

    Route::get('/measurements_table', 'App\Http\Controllers\DashboardController@measurements_table')
        ->name('measurements_table');


    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@dashboard')
        ->name('dashboard');

//    Route::get('/profile', 'App\Http\Controllers\DashboardController@profile')
//        ->name('profile');


});


//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
