<?php

namespace App\Http\Livewire;

use App\Models\Bumblebee;
use App\Models\Measurement;
use Carbon\Carbon;
use Livewire\Component;
use function Livewire\str;

class MeasurementForm extends Component
{
    public Measurement $measurement;
    public $allow_edit;
    public $create_new;
    public $render_count = 0;

    public $measurement_datetime;
    public $process = "";
    public $calibration_value;

    public $scaledColorimetric = 0;

    protected $rules = [

        'measurement.bumblebee_id' => 'string',
        'measurement_datetime' => 'string',
        'measurement.metric_sequence' => 'integer',
        'measurement.metric' => 'string|required',
        'measurement.method' => 'string|required',
        'measurement.process' => 'string',
        'measurement.value' => 'string',
        'measurement.unit' => 'string',
        'measurement.details' => 'string',
        'measurement.calibration_value' => 'numeric',
    ];

    /**
     * Render the form
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        debugbar()->info('Rendering: '.$this->render_count++);

        // ONLY copy into the variable the first time through when $this->>measurement_datetime is NOT SET
        // ALSO do not include seconds into the timestamp!   HTML does not properly check for this!
        if (!isset($this->measurement_datetime) && $this->create_new){
            $this->measurement_datetime =
                substr(str_replace(' ','T',$this->measurement->measurement_timestamp), 0, 16);
        }

        if(strlen($this->measurement->value) > 0 && !$this->create_new){
            debugbar()->info($this->measurement->value);
            debugbar()->info(json_decode($this->measurement->value));
            debugbar()->info(json_decode($this->measurement->value)->value);
            $this->measurement->value = json_decode($this->measurement->value)->value;
        }

        $this->calibration_value = $this->measurement->calibration_value === 1;

        return view('livewire.measurement-form',[
            'measurement' => $this->measurement,
            'allow_edit' => $this->allow_edit,
            'create_new' => $this->create_new,
            'bumblebees' => Bumblebee::all(),
        ]);
    }

    public function save(){
        debugbar()->info('Saving New Measurement');

        debugbar()->info($this->measurement_datetime);

        // Update variables
        $this->measurement->measurement_timestamp = str_replace('T', ' ', $this->measurement_datetime);


        $this->measurement->metric_sequence = 1;
        $prevMeasurement = $this->measurement->previousManualMeasurement();
        if (isset($prevMeasurement)){
            $this->measurement->metric_sequence = $prevMeasurement->metric_sequence + 1;
        }

        $this->measurement->value = json_encode([
            'value' => strval($this->measurement->value),
            ]);

        $validatedData = $this->validate();

        try {
            $this->measurement->saveOrFail();
            debugbar()->info('saved!');
        } catch (\Exception $e){
            debugbar()->info('Error...');
            debugbar()->error($e);
        }

        // revert the value back to a non-JSON view
        $this->measurement->value = json_decode($this->measurement->value)->value;
    }
}
