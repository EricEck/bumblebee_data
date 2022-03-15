<?php

namespace App\Http\Controllers;

use App\Models\Calibration;
use App\Models\Measurement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CalibrationController extends Controller
{

    /**
     * Open a new Larawire Calibration Form
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function calibrationFormNew(){

        debugbar()->info('CalibrationController::calibrationFormNew()');
        $measurement =  Session::get("measurement");
        if(!isset($measurement)){
            $measurement = new Measurement();       // send an empty measurement
        }
        $calibration = new Calibration();

        return view('calibrations.calibration_form', [
            'allow_edit' => true,
            'create_new' => true,
            'calibration' =>$calibration,
            'measurement' =>$measurement,
        ]);
    }
}
