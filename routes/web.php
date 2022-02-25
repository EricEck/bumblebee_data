<?php

use App\Http\Controllers\BumblebeeController;
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

    Route::get('/users_table', [UserController::class, 'indexView'])->name('users_table');
    Route::get('/user_form/edit/{user_id}', [UserController::class, 'userFormEdit']);
    Route::get('/user_form/show/{user_id}', [UserController::class, 'userFormShow']);

    Route::get('/bumblebees_table', [BumblebeeController::class, 'indexView'])->name('bumblebees_table');
    Route::get('/bumblebee_form/edit/{bumblebee_id}', [BumblebeeController::class, 'bumblebeeFormEdit']);
    Route::get('/bumblebee_form/show/{bumblebee_id}', [BumblebeeController::class, 'bumblebeeFormShow']);
    Route::get('/bumblebee_form/new', [BumblebeeController::class, 'bumblebeeFormNew']);

    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@dashboard')
        ->name('dashboard');

});


//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
