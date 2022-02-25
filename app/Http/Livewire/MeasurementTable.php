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
    public $orderBy = 'measurement_timestamp';
    public $calibrationMetric = false;
    public $measurementMetric = true;

    /**
     * All Measurements Index/Search
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.measurement-table',[
            'measurements' => Measurement::searchView($this->searchString, $this->measurementMetric, $this->calibrationMetric)
                ->orderBy($this->orderBy, $this->orderAscending ? 'asc' : 'desc')
                ->paginate($this->measurementsPerPage),
            'bumblebees' => Bumblebee::all(),
        ]);
    }
}
