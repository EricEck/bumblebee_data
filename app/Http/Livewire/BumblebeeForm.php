<?php

namespace App\Http\Livewire;

use App\Models\Bumblebee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;

class BumblebeeForm extends Component
{
    public Bumblebee $bumblebee;
    public bool $allow_edit;
    public bool $create_new;
    public string $new_password = '';

    protected $rules = [
        'bumblebee.serial_number' => 'required|string|min:4',
        'bumblebee.manufactured_date' => 'date|nullable',
        'bumblebee.current_version' => 'string|nullable',
        'bumblebee.manufacturer_id' => 'integer|nullable',
        'bumblebee.owner_id' => 'integer|nullable',
        'bumblebee.install_id' => 'integer|nullable',
        'bumblebee.assigned_to_owner_on' => 'date|nullable',
        'bumblebee.removed_from_service' => 'boolean',
        'bumblebee.api_password' => 'string|min:6|nullable',
        'bumblebee.remember_token' => 'uuid|nullable'
    ];

    /**
     * Render the View from the Model
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        debugbar()->info('Rendering');
        debugbar()->info($this->bumblebee->attributesToArray());

        return view('livewire.bumblebee-form',[
            'bumblebee' => $this->bumblebee,
            'allow_edit' => $this->allow_edit,
            'create_new' => $this->create_new,
        ]);
    }

    /**
     * Save using the validation and Model
     * @return void
     */
    public function save(){

        debugbar()->info('Saving New Bumblebee');

        // assign token and hash the password for new bumblebees
        if ($this->create_new){
            $this->bumblebee->remember_token = Str::uuid()->toString();
        }

        if (strlen($this->new_password) >= 6){
            $this->bumblebee->api_password = Hash::make($this->new_password);
        } elseif ( strlen($this->new_password) > 0 && strlen($this->new_password) < 6) {
            $this->addError('Password Length', 'Password must be at least 6 characters');
            return;
        } elseif ($this->create_new && strlen($this->new_password) < 6){
            $this->addError('New Bumblebee Password Required', 'New Password must be at least 6 characters');
            return;
        }

        if ($this->bumblebee->removed_from_service){
            $this->bumblebee->removed_from_service = true;
        } else {
            $this->bumblebee->removed_from_service = false;
        }

        $validatedData = $this->validate(); // if fail: this will perform an automatic return to the view with $this->errors set

        try {
            debugbar()->info('Saving...');
            $this->bumblebee->saveOrFail();
            debugbar()->info('bumblebee saved!');
        } catch (\Exception $e){
            debugbar()->info('Error...');
            debugbar()->error($e);
        }
    }
}
