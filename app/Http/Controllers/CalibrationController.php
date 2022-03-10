<?php

namespace App\Http\Controllers;

use App\Models\Calibration;
use App\Models\Measurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CalibrationController extends Controller
{
    //

    public function calibrationFormNew(){

        debugbar()->info('CalibrationController::calibrationFormNew()');

        $calibration = new Calibration([
            'calibrator_id' => Auth::user()->id,
            'effective' => 1,
            'effective_timestamp' => now(),
        ]);

//        dd($calibration->attributesToArray());

        $measurement =  Session::get("measurement");
        if(isset($measurement)){
            debugbar()->info("Measurement Sent");
            $calibration->bumblebee_id = $measurement->bumblebee_id;
            $calibration->metric = $measurement->metric;
            $calibration->method = $measurement->method;
            $calibration->calibration_type = $calibration->calibrationTypesForMethod($measurement->method)[0];
            $calibration->default_output_units = $measurement->validOutputUnitsForMetric()[0];
            $calibration->effective_timestamp = $measurement->measurement_timestamp;

        } else {
            $measurement = new Measurement();       // send an empty measurement
        }

        $calibration->effective_timestamp = str_replace(' ','T',$calibration->effective_timestamp); // swap to the local datatime format for html

        return view('calibrations.calibration_form', [
            'allow_edit' => true,
            'create_new' => true,
            'calibration' =>$calibration,
            'measurement' =>$measurement,
        ]);

    }
}
