<?php

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

Route::get('/', function () {
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

    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@dashboard')
        ->name('dashboard');

//    Route::get('/profile', 'App\Http\Controllers\DashboardController@profile')
//        ->name('profile');


});


//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
