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
        'measurement_date' => 'date|required',
        'measurement_datetime' => 'date_format:Y-m-d\TH:i:sP',
        'measurement_time' => 'string|required',
        'measurement.metric_sequence' => 'integer',
        'measurement.metric' => 'string|required',
        'measurement.method' => 'string|required',
        'measurement.process' => 'string',
        'measurement.value' => 'string',
        'measurement.unit' => 'string',
        'measurement.details' => 'string',
        'measurement.calibration_value' => 'numeric',
    ];

    public function render()
    {
        debugbar()->info('Rendering: '.$this->render_count++);

        $this->measurement_datetime = Carbon::now()->toDateTimeLocalString();

        if (isset($this->measurement)){
            $this->measurement_datetime = str_replace(' ','T',$this->measurement->measurement_timestamp);
        }

        $this->calibration_value = $this->measurement->calibration_value === 1;

//        if ($this->measurement->processIsJSON()) {
//            $this->process = $this->measurement->process;
//        }


        return view('livewire.measurement-form',[
            'measurement' => $this->measurement,
            'allow_edit' => $this->allow_edit,
            'create_new' => $this->create_new,
            'bumblebees' => Bumblebee::all(),
        ]);
    }

    public function save(){

    }
}
