<?php

namespace App\Http\Livewire;

use App\Models\BodiesOfWater;
use App\Models\Bumblebee;
use App\Models\Measurement;
use Carbon\Carbon;
use Livewire\Component;
use function Livewire\str;

class MeasurementForm extends Component
{
    public Measurement $measurement;
    public $bumblebees, $metrics, $methods, $units;
    public $bodiesOfWater, $bow_id;
    public $measurement_datetime;
    public $process = "";
    public $calibration_value;

    public $scaledColorimetric = 0;

    // Form Flags & Messaging
    public bool $showBack, $allow_edit, $create_new;
    public bool $saved, $readyToSave, $changed;
    public string $message;

    protected $rules = [
        'measurement.bumblebee_id' => 'required|exists:bumblebees,id',
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

    protected $casts = [];

    // Event Listeners - Livewire
    protected $listeners = [];


    public function mount(){
        debugbar()->info('mount: MeasurementForm');
        $this->changed = false;
        $this->readyToSave = false;
        $this->saved = false;
        $this->bumblebees = Bumblebee::all();
        $this->bodiesOfWater = BodiesOfWater::all();
        $this->metrics= Measurement::metricEnums();
        $this->methods= Measurement::methodEnums();
        $this->units = Measurement::unitEnums();
        if ($this->create_new) {
            $this->bow_id = "";
            $this->measurement->bumblebee_id = "";
            $this->measurement->unit = "";
            $this->measurement->metric = "";
            $this->measurement->method = "";
        }
    }

    /**
     * Render the form
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        debugbar()->info('render: MeasurementForm');

        // ONLY copy into the variable the first time through when $this->>measurement_datetime is NOT SET
        // ALSO do not include seconds into the timestamp!   HTML does not properly check for this!
        if (!isset($this->measurement_datetime) && $this->create_new){
            $this->measurement_datetime =
                substr(str_replace(' ','T',$this->measurement->measurement_timestamp), 0, 16);
        }

        //  never send a mech engineer to really do data software...  sheeshh...   :-)
        if(strlen($this->measurement->value) > 0 && !$this->create_new){
            debugbar()->info('$this->measurement->value');
            debugbar()->info($this->measurement->value);


            if($this->measurement->isManualMethod()){
                // manual probe data
                $this->measurement->value = json_decode($this->measurement->forceDoubleQuotedJSON())->value;
            } elseif($this->measurement->colorimetricMethod()){
                // automatic colorimetric data
                debugbar()->info('color auto');
                // don't return shit
            } else {
                // automatic probe data
                $this->measurement->value = json_decode($this->measurement->forceDoubleQuotedJSON())->value->value;
            }
        }

        $this->calibration_value = $this->measurement->calibration_value === 1;

        return view('livewire.measurement-form');
    }

    public function changed(){
        debugbar()->info('MeasurementForm Changed');
        $this->changed = true;

        if(count($this->units) == 1){
            $this->measurement->unit = $this->units[0];
        }
//
//        debugbar()->info($this->measurement->bumblebee_id);
//        debugbar()->info($this->measurement->metric);
//        debugbar()->info($this->measurement->method);
//        debugbar()->info($this->measurement->unit);
//        debugbar()->info($this->measurement->value);


        $this->units = $this->measurement->validOutputUnitsForMetric();

        $this->readyToSave = false;
        if($this->measurement->filled())
            $this->readyToSave = true;
    }

    public function discard(){
        debugbar()->info('MeasurementForm Discard');
        $this->emit('discardChanges');

        if($this->measurement->id)
            $this->measurement->refresh();
        else {
            $this->measurement = new Measurement();
            if ($this->create_new) {
                $this->bow_id = "";
                $this->measurement->bumblebee_id = "";
                $this->measurement->unit = "";
                $this->measurement->metric = "";
                $this->measurement->method = "";
            }
        }

        $this->readyToSave = false;
        $this->message = "Changes Discarded";
        $this->emit('message');
        $this->changed = false;
    }

    public function save(){
        debugbar()->info('Saving Measurement');

//        debugbar()->info($this->measurement_datetime);

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

        // run validation rule
        $validatedData = $this->validate();

        try {
            $this->measurement->saveOrFail();
            debugbar()->info('Measurement Saved');
            $this->saved = true;
            $this->changed = false;
            $this->message = "Measurement Saved";
            $this->emit('message');

        } catch (\Exception $e){
            $this->message = "Error Saving Measurement... ".$e->getMessage();
            $this->emit('message');   // alpine JS $this.on('message',() => {}) event
        }

        // revert the value back to a non-JSON view
        $this->measurement->value = json_decode($this->measurement->value)->value;
    }
}
