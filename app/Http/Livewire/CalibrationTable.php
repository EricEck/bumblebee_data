<?php

namespace App\Http\Livewire;

use App\Models\Calibration;
use Livewire\Component;

class CalibrationTable extends Component
{
    public $calibrations;

    public function mount(){
        \Debugbar::info('mount:CalibrationTable');
        $this->calibrations = Calibration::query()
            ->where('id', '>', 0)
            ->orderBy('id', 'desc')
            ->get();
    }
    public function render(){
        \Debugbar::info('render:CalibrationTable');
        return view('livewire.calibration-table');
    }

    // SUPPORT METHODS

    public function editCalibration($calibration_id){
        $this->redirectRoute('editCalibration', ['calibration_id' => $calibration_id]);
    }

    public function removeCalibration($calibration_id){
        $calibration = Calibration::find($calibration_id);
        if(!$calibration) abort(403, 'Calibration Not Found');
        $calibration->removeCalibrationAndUncalibrateEffectedMeasurements();
//        $this->calibrations->forget($calibration_id);
//        $this->calibrations->push($calibration);
        $this->calibrations = Calibration::all();
        $this->render();
    }
    public function runCalibration($calibration_id){

    }
}
