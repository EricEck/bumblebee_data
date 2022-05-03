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

    public $bumblebees;
    public $users;
    public $metrics;
    public $meas_methods;
    public $calibrationTypes;
    public $default_output_units;
    public $effectedMeasurementsCount;
    public $calibratedMeasurementsCount;

    public bool $changed;
    public string $message;
    public bool $no_changes;
    public bool $readyToSave;
    public bool $saved;
    public bool $newCalibration;

    protected $rules = [
        'calibration.bumblebee_id' => 'required|exists:bumblebees,id',
        'calibration.calibrator_id' => 'required|exists:users,id',
        'calibration.metric' => 'required|string',
        'calibration.method' => 'required|string',
        'calibration.calibration_type' => 'required|string',
        'calibration.effective' => 'integer',
        'calibration.effective_timestamp' => 'string',
        'calibration.slope_m' => 'numeric',
        'calibration.offset_b' => 'numeric',
        'calibration.default_output_units' => 'required|string',
    ];

    public function mount(){
        debugbar()->info('CalibrationForm.php::mount()');
        \Debugbar::info($this->calibration->attributesToArray());
        \Debugbar::info($this->measurement->attributesToArray());

        if(Session::get("measurement")) {
            $this->measurement = Session::get("measurement");
        }

        $this->newCalibration = false;


        // update from reference measurement if passed
        if($this->measurement->id > 0 && $this->calibration->id == 0){

            if($this->measurement->calibration_id > 0){
                // use an existing calibration
                $this->calibration = $this->measurement->calibration;
            } else {
                // Create a new calibration
                $this->calibration = new Calibration();
                $this->newCalibration = true;
                $this->calibration->bumblebee_id = $this->measurement->bumblebee_id;
                $this->calibration->calibrator_id = Auth::user()->id;
                $this->calibration->metric = $this->measurement->metric;
                $this->calibration->method = $this->measurement->method;
                $this->calibration->calibration_type = $this->calibration->calibrationTypesForMethod($this->measurement->method)[0];
                $this->calibration->default_output_units = $this->measurement->validOutputUnitsForMetric()[0];
                $this->calibration->effective = 1;
                $this->calibration->effective_timestamp = $this->measurement->measurement_timestamp;
            }
        }

        $this->bumblebees = Bumblebee::all();
        $this->users = \App\Models\User::all();
        $this->metrics = \App\Models\Measurement::metricEnums();
        $this->meas_methods = $this->calibration->calibrationMethodEnums();
        $this->calibrationTypes = $this->calibration->calibrationTypesForMethod();
        $this->default_output_units = $this->measurement->validOutputUnitsForMetric();


        $this->effectedMeasurementsCount = count($this->calibration->effectedMeasurements());   // not eloquent
        $this->calibratedMeasurementsCount = count($this->calibration->calibratedMeasurements);

        $this->no_changes = true;       // never not associated with a measurement at this stage
        $this->saved = false;
        $this->readyToSave = false;

        // short the string to remove seconds from the effective timestamp both for HTML and to assist in this calibration always being BEFORE the measurement
        $this->calibration_datetime = substr(str_replace(' ', 'T', $this->calibration->effective_timestamp), 0, 16);
    }
    public function render(){
        debugbar()->info('CalibrationForm.php::render()');
        return view('livewire.calibration-form');
    }
    public function changed(){

        debugbar()->info('CalibrationForm.php::changed()');

        $this->calibration->effective = intval($this->calibration->effective);
        $this->calibration->slope_m = $this->calibration->slope_m ? floatval($this->calibration->slope_m) : 0;
        $this->calibration->offset_b = $this->calibration->offset_b ? floatval($this->calibration->offset_b) : 0;

        debugbar()->info($this->calibration->filled());
        debugbar()->info($this->calibration->attributesToArray());
        $this->changed = true;
        $this->readyToSave = false;
        if ($this->calibration->filled()){
            $this->readyToSave = true;
            $this->message = "Ready to save...";
            $this->emit('message');
        }
    }

    public function discard(){
        debugbar()->info('Discard changes');
        if($this->calibration->id > 0){
            $this->calibration = $this->measurement->calibration;
        } else {
            $this->calibration = new Calibration();
            $this->calibration->bumblebee_id = $this->measurement->bumblebee_id;
            $this->calibration->calibrator_id = Auth::user()->id;
            $this->calibration->metric = $this->measurement->metric;
            $this->calibration->method = $this->measurement->method;
            $this->calibration->calibration_type = $this->calibration->calibrationTypesForMethod($this->measurement->method)[0];
            $this->calibration->default_output_units = $this->measurement->validOutputUnitsForMetric()[0];
            $this->calibration->effective = 1;
            $this->calibration->effective_timestamp = $this->measurement->measurement_timestamp;
        }

        // short the string to remove seconds from the effective timestamp both for HTML and to assist in this calibration always being BEFORE the measurement
        $this->calibration_datetime = substr(str_replace(' ', 'T', $this->calibration->effective_timestamp), 0, 16);

        $this->message = "Changes Discarded";
        $this->emit('message');
        $this->changed = false;
        $this->readyToSave = false;
    }

    public function runCalibration(){
        if(!$this->saved){
            $this->message="Save the calibration prior to running the calibrations";
            $this->emit('message');
            return;
        }

        debugbar()->info('Update Measurement Calibration');
        $this->message="Running Calibrations on Bumblebee Measurements...";
        $this->emit('message');

        // Run the calibration
        $calibratedMeasurements = $this->calibration->runCalibration();
        $this->message="Successfully Calibrated ".$calibratedMeasurements." Measurements...";
        $this->emit('message');
        $this->saved = false;
        $this->newCalibration = false;

//        $this->measurement->refresh();
//        $this->calibration->refresh();
    }

    public function save(){
        debugbar()->info('Saving New Calibration');

        $this->calibration->effective_timestamp = str_replace('T',' ',$this->calibration_datetime); // swap from the local datatime format for html

        // run validation rule
        $validatedData = $this->validate();

        try {
            $this->calibration->saveOrFail();
            debugbar()->info('saved!');
            $this->message = "Calibration Saved...";
            $this->emit('message');   // alpine JS $this.on('message',() => {}) event
            $this->changed = false;
            $this->saved = true;
            $this->readyToSave = false;

        } catch (\Exception $e){
            $this->message = "Error Saving Calibration...";
            $this->emit('message');   // alpine JS $this.on('message',() => {}) event
            debugbar()->info('Error Saving Calibration...');
            debugbar()->error($e);
        }

    }
}

//$c = new Calibration(["bumblebee_id" => 1,
//  "calibrator_id" => "4",
//  "metric" => "pressure",
//  "method" => "probe",
//  "calibration_type" => "linear",
//  "effective" => 1,
//  "effective_timestamp" => "2022-03-17 16:46:09",
//  "slope_m" => 25.0,
//  "offset_b" => -12.5,
//  "default_output_units" => "psi"]);
