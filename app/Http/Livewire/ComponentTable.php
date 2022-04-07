<?php

namespace App\Http\Livewire;

use App\Models\BowComponent;
use Livewire\Component;
use Livewire\WithPagination;

class ComponentTable extends Component
{
    use WithPagination;

    public $components;     // make this generic for ALL components

    public function mount(){

    }

    public function render()
    {
        return view('livewire.component-table');
    }
}
