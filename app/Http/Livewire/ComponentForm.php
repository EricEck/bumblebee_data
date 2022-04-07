<?php

namespace App\Http\Livewire;

use App\Models\BowComponent;
use Livewire\Component;
use function Symfony\Component\String\b;

class ComponentForm extends Component
{
    public BowComponent $bowComponent;
    public bool $showBack, $allow_edit, $create_new;

    public bool $saved;
    public bool $readyToSave;
    public bool $changed;

    public string $message;

    protected $rules = [
        'bowComponent.bodies_of_water_id' => 'exists:bodies_of_water,id',
        'bowComponent.name' => 'string',
        'bowComponent.description' => 'string',
        'bowComponent.elliptic_product_id' => 'numeric|nullable',
        'bowComponent.manufacturer_id' => 'numeric|nullable',
        'bowComponent.installation_service_company_id' => 'numeric',
        'bowComponent.installation_service_ticket_id' => 'numeric',
        'bowComponent.installation_date' => 'date|nullable',
        'bowComponent.installation_location_id' => 'exists:bow_component_locations',
        'bowComponent.installed_now' => 'boolean',
        'bowComponent.warranty' => 'boolean',
        'bowComponent.warranty_end_date' => 'date|nullable',
        'bowComponent.model_number' => 'string',
        'bowComponent.serial_number' => 'string',
        'bowComponent.removed_from_service_date' => 'date|nullable',
        'bowComponent.removed_from_service_ticket_id'=> 'numeric',
    ];

    protected $casts = [];

    // Event Listeners - Livewire
    protected $listeners = [];

    public function mount(){
        debugbar()->info('mount:ComponentForm');
//        debugbar()->info($this->bowComponent->attributesToArray());
    }

    public function render(){
        debugbar()->info('render:ComponentForm');
        return view('livewire.component-form');
    }

    public function changed(){
        debugbar()->info('ComponentForm Changed');
        $this->changed = true;

        $this->readyToSave = false;
        if($this->bowComponent->filled())
            $this->readyToSave = true;
    }

    public function discard(){
        debugbar()->info('ComponentForm Discard');
        $this->emit('discardChanges');

        $this->readyToSave = false;
        $this->message = "Changes Discarded";
        $this->emit('message');
        $this->changed = false;
    }

    public function save(){
        debugbar()->info('Saving bowComponent');


        // run validation rule
        $validatedData = $this->validate();
        try {
            $this->bowComponent->saveOrFail();
            debugbar()->info('bowComponent Saved');
            $this->saved = true;
            $this->changed = false;
            $this->message = "BoW Component Saved";
            $this->emit('message');
        } catch (\Exception $e){
            $this->message = "Error Saving BoW Component... ".$e->getMessage();
            $this->emit('message');   // alpine JS $this.on('message',() => {}) event
        }
    }
}
