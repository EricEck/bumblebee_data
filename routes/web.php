<?php

use App\Http\Controllers\BumblebeeController;
use App\Http\Controllers\CalibrationController;
use App\Http\Controllers\MeasurementController;
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

//// Remove this when done with power grid
//Route::view('/powergrid', 'powergrid-demo');

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

    Route::get('/users_table', [UserController::class, 'indexView'])
        ->name('users_table');
    Route::get('/user_form/edit/{user_id}', [UserController::class, 'userFormEdit'])
        ->name('user_form_edit');
    Route::get('/user_form/show/{user_id}', [UserController::class, 'userFormShow'])
        ->name('user_form_show');
    Route::get('/user_form/new', [UserController::class, 'userFormNew'])
        ->name('user_form_new');

    Route::get('elliptic_products', [\App\Http\Controllers\EllipticProductController::class, 'ellipticProductsList'])
        ->name('elliptic_product_list');
    Route::get('elliptic_products/new',[\App\Http\Controllers\EllipticProductController::class, 'ellipticProductNew'])
        ->name('elliptic_product_new');
    Route::get('elliptic_products/show/{id}',[\App\Http\Controllers\EllipticProductController::class, 'ellipticProductShow'])
        ->name('elliptic_product_show');
    Route::get('elliptic_products/edit/{id}',[\App\Http\Controllers\EllipticProductController::class, 'ellipticProductEdit'])
        ->name('elliptic_product_edit');

    Route::get('bodies_of_water', [\App\Http\Controllers\BodiesOfWaterController::class, 'indexView'])
        ->name('bodies_of_water');
    Route::get('bodies_of_water/new', [\App\Http\Controllers\BodiesOfWaterController::class, 'bodyOfWaterFormNew'])
        ->name('body_of_water_new');
    Route::get('bodies_of_water/edit/{bow_id}', [\App\Http\Controllers\BodiesOfWaterController::class, 'bodyOfWaterFormEdit'])
        ->name('body_of_water_edit');
    Route::get('bodies_of_water/show/{bow_id}', [\App\Http\Controllers\BodiesOfWaterController::class, 'bodyOfWaterFormShow'])
        ->name('body_of_water_show');

    Route::get('bow_components/all',[\App\Http\Controllers\BowComponentController::class, 'bowComponentsListAll'])
        ->name('bow_components_all');
    Route::get('bow_components/{bow_id}',[\App\Http\Controllers\BowComponentController::class, 'bowComponentsList'])
        ->name('bow_components_list');
    Route::get('bow_components/new/{bow_id}',[\App\Http\Controllers\BowComponentController::class, 'bowComponentNew'])
        ->name('bow_component_new');
    Route::get('bow_components/show/{bow_component_id}',[\App\Http\Controllers\BowComponentController::class, 'bowComponentShow'])
        ->name('bow_component_show');
    Route::get('bow_components/edit/{bow_component_id}',[\App\Http\Controllers\BowComponentController::class, 'bowComponentEdit'])
        ->name('bow_component_edit');

    Route::get('/bumblebees_table', [BumblebeeController::class, 'indexView'])
        ->name('bumblebees_table');
    Route::get('/bumblebee_form/edit/{bumblebee_id}', [BumblebeeController::class, 'bumblebeeFormEdit'])
        ->name('bumblebeeFormEdit');
    Route::get('/bumblebee_form/show/{bumblebee_id}', [BumblebeeController::class, 'bumblebeeFormShow'])
        ->name('bumblebeeFormShow');
    Route::get('/bumblebee_form/new', [BumblebeeController::class, 'bumblebeeFormNew']);



    Route::get('bumblebee/{bumblebee_id}', function ($bb_id){
        debugbar()->info('test: '.$bb_id);
        $bbc = new BumblebeeController();
        return $bbc->bumblebeeFormNew();
    });

    // Measurement Related
    Route::get('/measurements_table', [MeasurementController::class, 'indexView'])
        ->name('measurements_table');
    Route::get('/measurements_table/actual', [MeasurementController::class, 'actualView'])
        ->name('measurements_table_actual');
    Route::get('/measurements_table/{bumblebee_id}', [MeasurementController::class, 'indexViewOneBB'])
        ->name('measurements_bumblebee');
    Route::get('/measurements_form/show/{measurement_id}',
        [MeasurementController::class, 'measurementFormShow'])
        ->name('measurementFormShow');
    Route::get('/measurements_form/new',
        [MeasurementController::class, 'measurementFormNew'])
        ->name('measurementFormNew');

    // Horizontal Time shifts
    Route::get('measurements/bow',
        [MeasurementController::class, 'measurementBow'])
        ->name('measurementBow');
    Route::get('measurements/bow/{bow_id}',
        [MeasurementController::class, 'measurementBowById'])
        ->name('measurementBowId');

    // BoW Summary - App Like
    Route::get('bow/summary/{bow_id}',
        [MeasurementController::class, 'bowSummaryById'])
        ->name('bowSummaryById');

    // using get search parameters
//    Route::get('measurements',
//        [MeasurementController::class, 'measurementSearchTable'])
//    ->name('measurement_search');

    Route::get('calibrations',
        [CalibrationController::class, 'calibrationTable'])
        ->name('calibrationTable');
    Route::get('calibrations/new',
        [CalibrationController::class, 'calibrationFormNew'])
        ->name('calibrationFormNew');
    Route::get('calibrations/existing',
        [CalibrationController::class, 'calibrationFromExisting'])
        ->name('calibrationFormExisting');
    Route::get('calibrations/edit/{calibration_id}',
        [CalibrationController::class, 'editCalibrationForm'])
        ->name('editCalibration');

    // Data Table Downloads
//    Route::get('/export/users/excel', [UserController::class, 'exportExcel']);
//    Route::get('/export/users/csv', [UserController::class, 'exportCSV']);
    Route::get('/export/users/search', [UserController::class, 'exportSearchExcel']);
    Route::get('/export/measurements/search', [MeasurementController::class, 'exportSearchCSV']);
    Route::get('/export/measurements/all/csv', [MeasurementController::class, 'exportCSV']);

    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@dashboard')
        ->name('dashboard');

});


//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
