<?php

namespace App\Http\Livewire;

use App\Models\BowComponent;
use App\Models\BowComponentLocation;
use App\Models\ComponentManufacturer;
use Livewire\Component;
use function Symfony\Component\String\b;

class ComponentForm extends Component
{

    public int $bow_id;
    public BowComponent $bowComponent;

    public $componentManufacturers;
    public ?ComponentManufacturer $newComponentManufacturer;
    public $showAddComponentManufacturer;

    public $componentLocations;
    public ?BowComponentLocation $newComponentLocation;
    public $showAddComponentLocation;

    // Form Flags & Messaging
    public bool $showBack, $allow_edit, $create_new;
    public bool $saved, $readyToSave, $changed;
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
    protected $listeners = [
        'closeComponentManufacturerForm' => 'closeAddComponentManufacturer',
        'closeComponentLocationForm' => 'closeAddComponentLocation',
    ];

    public function mount(){
        debugbar()->info('mount:ComponentForm');
        $this->componentManufacturers = ComponentManufacturer::allEllipticFirst();
        $this->componentLocations = BowComponentLocation::allForBodyOfWaterId($this->bowComponent->bodies_of_water_id);
        $this->showAddComponentManufacturer = false;
        $this->showAddComponentLocation = false;
    }

    public function render(){
        debugbar()->info('render:ComponentForm');
        return view('livewire.component-form');
    }

    public function addComponentLocation(){
        debugbar()->info('addComponentLocation: ');
        $this->newComponentLocation = new BowComponentLocation([
            'bodies_of_water_id' => $this->bowComponent->bodies_of_water_id,
            ]);
        $this->showAddComponentLocation = true;
    }
    public function closeAddComponentLocation(){
        $this->showAddComponentLocation = false;
        // default to the newly added
        $this->bowComponent->installation_location_id = -1;
        $this->componentLocations = BowComponentLocation::allForBodyOfWaterId($this->bowComponent->bodies_of_water_id);  // reload the locations
    }

    public function addComponentManufacturer(){
        debugbar()->info('addComponentManufacturer: ');
        $this->newComponentManufacturer = new ComponentManufacturer();
        $this->showAddComponentManufacturer = true;
    }
    public function closeAddComponentManufacturer(){
        $this->showAddComponentManufacturer = false;
        // default to the newly added
        $this->bowComponent->manufacturer_id = $this->newComponentManufacturer->id;
        $this->componentManufacturers = ComponentManufacturer::allEllipticFirst();  // reload the equipement mfg
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

        if($this->bowComponent->id)
            $this->bowComponent->refresh();
        else
            $this->bowComponent = new BowComponent([
                'bodies_of_water_id' => $this->bow_id,
            ]);

        $this->newComponentManufacturer = new ComponentManufacturer();
        $this->newComponentLocation = new BowComponentLocation([
            'bodies_of_water_id' => $this->bowComponent->bodies_of_water_id,
        ]);

        $this->showAddComponentManufacturer = false;
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
