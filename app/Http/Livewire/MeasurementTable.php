<?php

namespace App\Http\Livewire;

use App\Http\Controllers\CalibrationController;
use App\Models\Bumblebee;
use App\Models\Measurement;
use Carbon\Carbon;
use League\CommonMark\Extension\CommonMark\Node\Block\ThematicBreak;
use Livewire\Component;
use Livewire\WithPagination;

class MeasurementTable extends Component
{
    use WithPagination;

    public Bumblebee $bumblebee_select;

    public $measurementsPerPage = 10;
    public $scaledColorimetric = 0;

    public $orderAscending = "desc";

//    public $calibrationMetric = false;
//    public $measurementMetric = true;
    public $bumblebeeID = 0;
    public $metric = "all";
    public $method = "all";
    public $types = "2";

    public $start_datetime = null;
    public $end_datetime = null;

    public $sort_by = "time";

    public  $renders =0;

    public $actualOnly = 0;



    public function mount(){
        debugbar()->info('mount: MeasurementTable');
        if($this->actualOnly){
            debugbar()->info('Actual Only Measurements');
            $this->types = 3;
        } else {
            debugbar()->info('Open Measurements');
        }

        if($this->method == null) $this->method = "all";

        if ($this->start_datetime == null){
            $this->start_datetime = Carbon::now()->sub("21 days")->format('Y-m-d\Th:i');
        }

        if ($this->end_datetime == null){
            $this->end_datetime = Carbon::tomorrow()->format('Y-m-d\Th:i');
        }

        if(isset($this->bumblebee_select)){
            debugbar()->info('Use only this bumblebee: '.$this->bumblebee_select);
        }

    }

    /**
     * All Measurements Index/Search
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        debugbar()->info('render: MeasurementTable');

//        debugbar()->info('MeasurementTable.php');
//        debugbar()->info('Renders: '.$this->renders++);
//        debugbar()->info('Per Page: '.$this->measurementsPerPage);
//        debugbar()->info('BB ID: '.$this->bumblebeeID);
//        debugbar()->info('Metrics: '.$this->metric);
//        debugbar()->info('Methods: '.$this->method);
//        debugbar()->info('$this->start_datetime: '.$this->start_datetime);
//        debugbar()->info('$this->end_datetim: '.$this->end_datetime);
//        debugbar()->info('Sort by: '.$this->sort_by);
//        debugbar()->info('Order in: '.$this->orderAscending );


        return view('livewire.measurement-table',[

            'measurements' => Measurement::searchView(
                $this->bumblebeeID,
                $this->metric,
                $this->method,
                $this->types,
                $this->start_datetime,
                $this->end_datetime,
                $this->sort_by,
                $this->orderAscending)
                ->paginate($this->measurementsPerPage),

            'bumblebees' => Bumblebee::all(),
        ]);
    }

    /**
     * Export a specific set of Measurements to Excel
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function excel(){

        return redirect('/export/measurements/search')->with([
            'bumblebeeID' => $this->bumblebeeID,
            'metric' => $this->metric,
            'method' => $this->method,
            'types' => $this->types,
            'start_datetime' => $this->start_datetime,
            'end_datetime' => $this->end_datetime,
            'sort_by' => $this->sort_by,
            'orderAscending' => $this->orderAscending,
        ]);

    }

    /**
     * Redirect to the Measurement Form URL
     * @param int $measurementID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function measurementFormShow(int $measurementID){
        return redirect()->to('/measurements_form/show/'.$measurementID);
    }

    /**
     * Redirect to the Measurement Form URL Route to Create a New Measurement
     * @return \Illuminate\Http\RedirectResponse
     */
    public function measurementFormNew(){
        return redirect()->to('/measurements_form/new');
    }

    /**
     * Redirect to the New Calibrations form URL with the reference seed information
     * @param int $measurmentID optional
     * @return \Illuminate\Http\RedirectResponse
     */
    public function calibrationFormNew(int $measurmentID = 0){
        $m = Measurement::find($measurmentID);
        if($measurmentID){
            $m = Measurement::find($measurmentID);
            return redirect()->to('/calibrations/new/')->with([
                "measurement" => $m,
            ]);
        }
        return redirect()->to('/calibrations/new/');
    }

    /**
     * Redirect to the Existing Calibration form URL
     * @param $measurmentID
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function calibrationFormExisting($measurmentID){
        $m = Measurement::find($measurmentID);
        if($m && $m->calibration_id > 0){
            return redirect()->to('/calibrations/existing/')->with([
                "measurement" => $m,
            ]);
        }
        debugbar()->error('Bad call to existing measurement ID '.$measurmentID.' existing calibration');
        return null;
    }

    /**
     * Calibrate only the search table measurements
     * ignores pagination
     *
     * @return void
     */
    public function calibrateMeasurements(){
        debugbar()->info('calibrateMeasurements');

        $this->emit('hideCalibrationButton');
        $this->emit('calibrating');   // alpine JS $this.on('saved',() => {}) event

        // get all the measurements, not just the paginated ones.
        // must sort by timestamp ascending to get proper order
        $allMeasurements = Measurement::searchView(
            $this->bumblebeeID,
            $this->metric,
            $this->method,
            $this->types,
            $this->start_datetime,
            $this->end_datetime,
            "time",
            "asc")->get();

        foreach ($allMeasurements as $measurement) {
            try {
                $measurement->calibrate();
            } catch (\Exception $e){
                debugbar()->error('MeasurementTable::calibrateMeasurements => Error...');
                debugbar()->error($e);
            }
        }
        $this->emit('calibrationComplete');   // alpine JS $this.on('calibrationComplete',() => {}) event
    }
}
