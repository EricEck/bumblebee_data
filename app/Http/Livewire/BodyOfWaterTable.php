<?php

namespace App\Http\Livewire;

use App\Models\BodiesOfWater;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class BodyOfWaterTable extends Component
{
    use WithPagination;

    public Collection $bows;

    public function mount(){
        debugbar()->info('mounting: BodyOfWaterTable');
        $this->bows = BodiesOfWater::all();
    }

    public function render(){
        debugbar()->info('render: BodyOfWaterTable');
        return view('livewire.body-of-water-table');
    }
}
