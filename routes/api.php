<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BumblebeeController;
use App\Http\Controllers\MeasurementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

/*
 * Protected Routes
 */
Route::group(['middleware' => ['auth:sanctum']], function (){

    Route::post('/measurement/post/', [MeasurementController::class, 'store']);
    Route::get('/measurement/show/all', [MeasurementController::class, 'index']);
    Route::get('/measurement/show/{id}', [MeasurementController::class, 'show']);
    Route::get('/measurement/show/bumblebee/{id}', [MeasurementController::class, 'searchBumblebee']);
    Route::get('/measurement/show/bumblebee/{id}/{metric}', [MeasurementController::class, 'searchBumblebeeMetric']);
    Route::put('/measurement/update/{id}', [MeasurementController::class, 'update']);
    Route::delete('/measurement/delete/{id}', [MeasurementController::class, 'destroy']);

    Route::post('/calibration/post/', [MeasurementController::class, 'storeCalibration']);
    Route::get('/calibration/show/all', [MeasurementController::class, 'indexCalibration']);
    Route::get('/calibration/show/{id}', [MeasurementController::class, 'showCalibration']);
    Route::get('/calibration/show/bumblebee/{id}', [MeasurementController::class, 'searchBumblebeeCalibration']);
    Route::get('/calibration/show/bumblebee/{id}/{metric}', [MeasurementController::class, 'searchBumblebeeMetricCalibration']);
    Route::delete('/calibration/delete/{id}', [MeasurementController::class, 'destroyCalibration']);

    Route::get('/bumblebee/show/all', [BumblebeeController::class, 'index']);
    Route::get('/bumblebee/show/{id}', [BumblebeeController::class, 'show']);
    Route::post('/bumblebee/post/', [BumblebeeController::class, 'store']);
    Route::put('/bumblebee/update/{id}', [BumblebeeController::class, 'update']);
    Route::delete('/bumblebee/delete/{id}', [BumblebeeController::class, 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);

});

/**
 * Public Routes
 */

// Return Version of Bumblebee API
Route::get('/version', function (){
    return Response::json([
        'application' => config('app.name'),
        'data_model' => 'bumblebee',
        'api_version' => config('app.api_version'),
    ], 200);
});
