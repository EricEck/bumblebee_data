<?php

namespace App\Http\Livewire;

use App\Models\Bumblebee;
use App\Models\Calibration;
use App\Models\Measurement;
use Livewire\Component;


class CalibrationForm extends Component
{
    public Calibration $calibration;
    public bool $allow_edit;
    public bool $create_new;
    public Measurement $measurement;
    public $calibration_datetime;

    protected $rules = [
        'calibration.bumblebee_id' => 'required|exists:bumblebees',
        'calibration.metric' => 'required|string',
        'calibration.method' => 'required|string',
        'calibration.calibration_type' => 'required|string',
        'calibration.effective_timestamp' => 'string',
        'calibration.slope_m' => 'numeric',
        'calibration.offset_b' => 'numeric',
        'calibration.default_output_units' => 'required|string',
    ];


    public function render()
    {
        debugbar()->info('CalibrationForm.php::render()');

        if(!isset($this->calibration)) $this->calibration = new Calibration();
        if(!isset($this->measurement)) $this->measurement = new Measurement();

        if (isset($this->calibration) && $this->create_new){
            $this->calibration_datetime = str_replace(' ','T',$this->calibration->effective_timestamp);
        }

//        debugbar()->info('Cal');
//        debugbar()->info($this->calibration->attributesToArray());
//
//        debugbar()->info('Meas');
//        debugbar()->info($this->measurement->attributesToArray());

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

        $this->effective_timestamp = str_replace('T',' ',$this->calibration_datetime); // swap from the local datatime format for html

//        $this->effective_timestamp = str_replace(' ','T',$this->effective_timestamp); // swap back to the local datatime format for html

        $validatedData = $this->validate();

        dd($this);
        try {
            $this->calibration->saveOrFail();
            debugbar()->info('saved!');
        } catch (\Exception $e){
            debugbar()->info('Error...');
            debugbar()->error($e);
        }

    }
}
