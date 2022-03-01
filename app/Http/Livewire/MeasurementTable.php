<?php

namespace App\Http\Livewire;

use App\Models\Bumblebee;
use App\Models\Measurement;
use League\CommonMark\Extension\CommonMark\Node\Block\ThematicBreak;
use Livewire\Component;
use Livewire\WithPagination;

class MeasurementTable extends Component
{
    use WithPagination;

    public $measurementsPerPage = 10;
    public $searchString = '';
    public $orderAscending = false;
    public $orderBy = 'id';
    public $calibrationMetric = false;
    public $measurementMetric = true;
    public $bumblebeeID = 0;
    public $metric = "all";
    public $method = "all";

    public  $renders =0;
    /**
     * All Measurements Index/Search
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {

        debugbar()->info('Renders: '.$this->renders++);
        debugbar()->info('Per Page: '.$this->measurementsPerPage);
        debugbar()->info('BB ID: '.$this->bumblebeeID);
        debugbar()->info('Metrics: '.$this->metric);

        return view('livewire.measurement-table',[

            'measurements' => Measurement::searchView($this->searchString,$this->bumblebeeID,$this->metric, $this->method)
                ->orderBy($this->orderBy,
                        $this->orderAscending ? 'asc' : 'desc')
                ->paginate($this->measurementsPerPage),

            'bumblebees' => Bumblebee::all(),
        ]);
    }
}
