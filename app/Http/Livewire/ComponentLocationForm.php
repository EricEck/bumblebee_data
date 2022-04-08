<?php

namespace App\Http\Livewire;

use App\Models\BowComponentLocation;
use Livewire\Component;

class ComponentLocationForm extends Component
{

    public ?BowComponentLocation $componentLocation;

    public int $bow_id;

    public bool $showBack, $allow_edit, $create_new, $showClose;
    public bool $closeAfterSaved = false;

    public bool $saved;
    public bool $readyToSave;
    public bool $changed;

    public string $message;

    protected $rules = [
        'componentLocation.name' => 'string|min:2',
        'componentLocation.description' => 'string',
    ];

    protected $casts = [];

    // Event Listeners - Livewire
    protected $listeners = [];



    public function mount(){
        debugbar()->info('mount:ComponentLocationForm: bow_id:'.$this->bow_id);
    }

    public function render()
    {
        return view('livewire.component-location-form');
    }

    public function changed(){
        debugbar()->info('ComponentLocationForm Changed');

        debugbar()->info($this->closeAfterSaved);

        $this->changed = true;

        $this->readyToSave = false;
        if($this->componentLocation->filled())
            $this->readyToSave = true;
    }

    public function discard(){
        debugbar()->info('ComponentLocationForm Discard');
        $this->emit('discardChanges');

        if ($this->componentLocation->id)
            $this->componentLocation->refresh();
        else
            $this->componentLocation = new BowComponentLocation([
                'bodies_of_water_id' => $this->bow_id,
            ]);

        $this->readyToSave = false;
        $this->message = "Changes Discarded";
        $this->emit('message');
        $this->changed = false;
    }

    public function closeForm(){
        debugbar()->info('Closing ComponentLocationForm');
        $this->emitUp('closeComponentLocationForm');
    }

    public function save(){
        debugbar()->info('Saving ComponentLocation');

        // run validation rule
        $validatedData = $this->validate();
        try {
            $this->componentLocation->bodies_of_water_id = $this->bow_id;
            debugbar()->info($this->componentLocation->attributesToArray());
            $this->componentLocation->saveOrFail();
            debugbar()->info('componentLocation Saved');
            $this->saved = true;
            $this->changed = false;
            $this->message = "Component Location Saved";
            $this->emit('message');

//            if($this->closeAfterSaved)
//                $this->closeForm();

        } catch (\Exception $e){
            $this->message = "Error Saving Component Location... ".$e->getMessage();
            $this->emit('message');   // alpine JS $this.on('message',() => {}) event
        }
    }

}
