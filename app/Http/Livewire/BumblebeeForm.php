<?php

namespace App\Http\Livewire;

use App\Models\Bumblebee;
use Livewire\Component;

class BumblebeeForm extends Component
{
    public Bumblebee $bumblebee;
    public bool $allow_edit;

    protected $rules = [
        'bumblebee.serial_number' => 'required|min:4|max:25',
        'bumblebee.manufactured_date' => 'required|date',
        'bumblebee.current_version' => 'required|min:4|max:20',
        'bumblebee.owner_id' => 'int',
        'bumblebee.assigned_to_owner_on' => 'date',
        'bumblebee.removed_from_service' => 'bool',
        'bumblebee.api_password' => 'password:min(6)'
    ];

    /**
     * Render the View from the Model
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.bumblebee-form',[
            'bumblebee' => $this->bumblebee,
            'allow_edit' => $this->allow_edit,
        ]);
    }

    /**
     * Save using the validation and Model
     * @return void
     */
    public function save(){
        $this->validate();
        $this->bumblebee->save();
        debugbar()->info('bumblebee saved!');
    }
}
