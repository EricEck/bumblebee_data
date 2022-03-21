<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Modal extends Component
{
    public $show = false;

    // Event Listener Bindings
    protected $listeners =[
        'show' => 'show',
    ];

    public function show(){
        $this->show = true;
    }
}
