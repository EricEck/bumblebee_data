<?php

namespace App\Http\Livewire;

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
    /**
     * All Measurements Index/Search
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {

        if(isset($this->bumblebee_select)){
            debugbar()->info($this->bumblebee_select);
        }

        if ($this->start_datetime == null){
            $this->start_datetime = Carbon::now()->sub("7 days")->format('Y-m-d\Th:i');
        }

        if ($this->end_datetime == null){
            $this->end_datetime = Carbon::tomorrow()->format('Y-m-d\Th:i');
        }


        debugbar()->info('Renders: '.$this->renders++);
        debugbar()->info('Per Page: '.$this->measurementsPerPage);
        debugbar()->info('BB ID: '.$this->bumblebeeID);
        debugbar()->info('Metrics: '.$this->metric);
        debugbar()->info('Start: '.$this->start_datetime);
        debugbar()->info('End: '.$this->end_datetime);
        debugbar()->info('Sort by: '.$this->sort_by);
        debugbar()->info('Order in: '.$this->orderAscending );


        return view('livewire.measurement-table',[

            'measurements' => Measurement::searchView(
                $this->bumblebeeID, $this->metric, $this->method, $this->types,
                $this->start_datetime, $this->end_datetime, $this->sort_by, $this->orderAscending)
                ->paginate($this->measurementsPerPage),

            'bumblebees' => Bumblebee::all(),
        ]);
    }

    /**
     * Redirect to the Measurement Form URL
     * @param int $measurementID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function measurementFormShow(int $measurementID)
    {
        return redirect()->to('/measurements_form/show/'.$measurementID);
    }

    /**
     * Redirect to the Measurement Form URL Route to Create a New Measurement
     * @return \Illuminate\Http\RedirectResponse
     */
    public function measurementFormNew()
    {
        return redirect()->to('/measurements_form/new');
    }
}
