<?php

namespace App\Http\Livewire;

use App\Models\ComponentManufacturer;
use Livewire\Component;

class ComponentManufacturerForm extends Component
{

    public ?ComponentManufacturer $componentManufacturer;

    public bool $showBack, $allow_edit, $create_new, $showClose;
    public bool $closeAfterSaved = false;

    public bool $saved;
    public bool $readyToSave;
    public bool $changed;

    public string $message;

    protected $rules = [
        'componentManufacturer.name' => 'string|min:2',
        'componentManufacturer.description' => 'string',
        'componentManufacturer.website_main_url' => 'string',
        'componentManufacturer.website_service_url' => 'string',
    ];

    protected $casts = [];

    // Event Listeners - Livewire
    protected $listeners = [];



    public function mount(){
        debugbar()->info('mount:ComponentManufacturerForm');
    }

    public function render(){

        debugbar()->info('render:ComponentManufacturerForm');
        debugbar()->info($this->componentManufacturer->attributesToArray());
        return view('livewire.component-manufacturer-form');
    }

    public function changed(){
        debugbar()->info('ComponentManufacturerForm Changed');

        debugbar()->info($this->closeAfterSaved);

        $this->changed = true;

        $this->readyToSave = false;
        if($this->componentManufacturer->filled())
            $this->readyToSave = true;
    }

    public function discard(){
        debugbar()->info('ComponentManufacturerForm Discard');
        $this->emit('discardChanges');

        if ($this->componentManufacturer->id)
            $this->componentManufacturer->refresh();
        else
            $this->componentManufacturer = new ComponentManufacturer();

        $this->readyToSave = false;
        $this->message = "Changes Discarded";
        $this->emit('message');
        $this->changed = false;
    }

    public function closeForm(){
        debugbar()->info('Closing ComponentManufacturer');
        $this->emitUp('closeComponentManufacturerForm');
    }

    public function save(){
        debugbar()->info('Saving ComponentManufacturer');

        // run validation rule
        $validatedData = $this->validate();
        try {
            $this->componentManufacturer->saveOrFail();
            debugbar()->info('ComponentManufacturer Saved');
            $this->saved = true;
            $this->changed = false;
            $this->message = "Component Manufacturer Saved";
            $this->emit('message');

            if($this->closeAfterSaved)
                $this->closeForm();

        } catch (\Exception $e){
            $this->message = "Error Saving Component Manufacturer... ".$e->getMessage();
            $this->emit('message');   // alpine JS $this.on('message',() => {}) event
        }
    }

}
