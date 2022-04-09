<?php

namespace App\Http\Livewire;

use App\Models\Bumblebee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;

class BumblebeeForm extends Component
{
    public Bumblebee $bumblebee;
    public string $new_password = '';
    public  $users;

    // Form Flags & Messaging
    public bool $showBack, $allow_edit, $create_new;
    public bool $saved, $readyToSave, $changed;
    public string $message;

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

    protected $casts = [];

    // Event Listeners - Livewire
    protected $listeners = [];


    public function mount(){
        debugbar()->info('mount: BumblebeeForm');
        $this->changed = false;
        $this->readyToSave = false;
        $this->saved = false;
        $this->users = User::query()
            ->where('id','>','0')
            ->orderBy('name', 'asc')
            ->get();
    }

    public function render()
    {
        debugbar()->info('render: BumblebeeForm');
        debugbar()->info($this->bumblebee->attributesToArray());

        return view('livewire.bumblebee-form');
    }

    public function changed(){
        debugbar()->info('ComponentForm Changed');
        $this->changed = true;

        $this->readyToSave = false;
        if($this->bumblebee->filled())
            $this->readyToSave = true;
    }

    public function discard(){
        debugbar()->info('BumblebeeForm Discard');
        $this->emit('discardChanges');

        if($this->bumblebee->id)
            $this->bumblebee->refresh();
        else
            $this->bumblebee = new Bumblebee();

        $this->readyToSave = false;
        $this->message = "Changes Discarded";
        $this->emit('message');
        $this->changed = false;
    }

    /**
     * Save using the validation and Model
     * @return void
     */
    public function save(){

        debugbar()->info('Saving Bumblebee');

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

            $this->bumblebee->saveOrFail();
            debugbar()->info('Bumblebee Saved');
            $this->saved = true;
            $this->changed = false;
            $this->message = "Bumblebee Saved";
            $this->emit('message');
        } catch (\Exception $e){
            $this->message = "Error Saving Bumblebee... ".$e->getMessage();
            $this->emit('message');   // alpine JS $this.on('message',() => {}) event
        }
    }
}
