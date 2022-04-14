<?php

namespace App\Http\Livewire;

use App\Models\BodiesOfWater;
use App\Models\BowComponent;
use Livewire\Component;
use Livewire\WithPagination;

class ComponentTable extends Component
{
    use WithPagination;

    public $bow;

    public function mount(){
        debugbar()->info('mount: ComponentTable');
    }


    public function render(){
        debugbar()->info('render: ComponentTable');
        return view('livewire.component-table');
    }
}
