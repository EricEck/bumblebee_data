<?php

namespace App\Http\Livewire;

use App\Models\Bumblebee;
use Livewire\Component;
use Livewire\WithPagination;

class BumblebeeTable extends Component
{
    use WithPagination; // must add for livewire

    public $bumblebeesPerPage = 15;
    public $searchString = '';
    public $orderAscending = true;
    public $orderBy = 'serial_number';

    /**
     * All Bumblebees Index/Search
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.bumblebee-table',[
            'bumblebees' => Bumblebee::searchView($this->searchString)
                ->orderBy($this->orderBy, $this->orderAscending ? 'asc' : 'desc')
                ->paginate($this->bumblebeesPerPage)]);
    }
}
