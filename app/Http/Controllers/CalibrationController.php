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

    public function calibrationTable(){
        \Debugbar::info('CalibrationController: calibrationTable');
        return view('calibrations.index');
    }

    /**
     * Open a new Larawire Calibration Form Page
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

    /**
     * Open Calibration Form from only an existing Calibration
     * @param int $calibration_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function editCalibrationForm(int $calibration_id){
        $calibration = Calibration::find($calibration_id);
        if(!$calibration) abort(404);

        $measurement = $calibration->effectedMeasurements()[0]; // get the first effected Measurement
        if(!$measurement) abort(404);

        return view('calibrations.calibration_form', [
            'allow_edit' => true,
            'create_new' => false,
            'calibration' =>$calibration,
            'measurement' =>$measurement,
        ]);
    }

    /**
     * Open an existing Larawire Calibration Form Page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|never
     */
    public function calibrationFromExisting(){

        debugbar()->info('CalibrationController::calibrationFormExisting()');

        $measurement =  Session::get("measurement");
        if($measurement){
            $calibration = Calibration::find($measurement->calibration_id);
            return view('calibrations.calibration_form', [
                'allow_edit' => true,
                'create_new' => false,
                'calibration' =>$calibration,
                'measurement' =>$measurement,
            ]);
        }
        return abort(404);
    }
}
