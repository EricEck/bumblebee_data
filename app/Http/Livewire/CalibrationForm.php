<?php

namespace App\Http\Livewire;

use App\Models\Bumblebee;
use App\Models\Calibration;
use App\Models\Measurement;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;


class CalibrationForm extends Component
{
    public Calibration $calibration;
    public bool $allow_edit;
    public bool $create_new;
    public Measurement $measurement;
    public $calibration_datetime;

    // Helper function variables
    public float $x1 = 0,$y1 = 0,$x2 = 0,$y2 = 0, $slope_m = 0,$offset_b = 0;

    protected $rules = [
        'calibration.bumblebee_id' => 'required|exists:bumblebees,id',
        'calibration.calibrator_id' => 'required|exists:users,id',
        'calibration.metric' => 'required|string',
        'calibration.method' => 'required|string',
        'calibration.calibration_type' => 'required|string',
        'calibration.effective_timestamp' => 'string',
        'calibration.slope_m' => 'numeric',
        'calibration.offset_b' => 'numeric',
        'calibration.default_output_units' => 'required|string',
    ];

    public function mount(){

        debugbar()->info('CalibrationForm.php::mount()');

        if($this->calibration->id == 0) {
            $this->calibration->bumblebee_id = 0;
            $this->calibration->calibrator_id = Auth::user()->id;
            $this->calibration->effective = 1;
            $this->calibration->effective_timestamp = Carbon::now()->toDateTimeLocalString('minute');

    //        $this->calibration->slope_m = 1;
    //        $this->calibration->offset_b = 0;
        }

        // update from reference measurement
        if(Session::get("measurement")){
            $this->measurement =  Session::get("measurement");
            debugbar()->info("Measurement Received");
            $this->calibration->bumblebee_id = $this->measurement->bumblebee_id;
            $this->calibration->metric = $this->measurement->metric;
            $this->calibration->method = $this->measurement->method;
            $this->calibration->calibration_type = $this->calibration->calibrationTypesForMethod($this->measurement->method)[0];
            $this->calibration->default_output_units = $this->measurement->validOutputUnitsForMetric()[0];
            $this->calibration->effective_timestamp = $this->measurement->measurement_timestamp;
        }

        // short the string to remove seconds from the effective timestamp both for HTML and to assist in this calibration always being BEFORE the measurement
        $this->calibration_datetime = substr(str_replace(' ', 'T', $this->calibration->effective_timestamp), 0, 16);
    }

    public function render()
    {
        debugbar()->info('CalibrationForm.php::render()');
        debugbar()->info($this->calibration->attributesToArray());

        // ONLY copy into the variable the first time through when $this->>measurement_datetime is NOT SET
        // ALSO do not include seconds into the timestamp!   HTML does not properly check for this!
//        if (!isset($this->calibration_datetime) && $this->create_new){
//            $this->calibration_datetime = substr(str_replace(' ','T',$this->calibration->effective_timestamp),0,16);
//        }
        debugbar()->info('cal meas:');
        debugbar()->info($this->measurement->attributesToArray());

        // Calculation Assistant
//        $temp = $this->calibration->solveLinearSlopeAndOffset($this->x1, $this->y1, $this->x2, $this->y2);
//        debugbar()->info($temp);
//        $this->slope_m = $temp["slope_m"];
//        $this->offset_b = $temp["offset_b"];

        return view('livewire.calibration-form',[
            "calibration" => $this->calibration,
            "allow_edit" => $this->allow_edit,
            "create_new" => $this->create_new,
            "measurement" => $this->measurement,
            "bumblebees" => Bumblebee::all(),
        ]);
    }

    public function save(){
        debugbar()->info('Saving New Calibration');

        $this->calibration->effective_timestamp = str_replace('T',' ',$this->calibration_datetime); // swap from the local datatime format for html

        // run validation rule
        $validatedData = $this->validate();


        try {
            $this->calibration->saveOrFail();
            debugbar()->info('saved!');

            $this->emit('saved');   // alpine JS $this.on('saved',() => {}) event

        } catch (\Exception $e){
            debugbar()->info('Error...');
            debugbar()->error($e);
        }

    }
}
