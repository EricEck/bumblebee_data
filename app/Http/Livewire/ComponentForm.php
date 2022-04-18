<?php

namespace App\Http\Livewire;

use App\Models\BodiesOfWater;
use App\Models\BowComponent;
use App\Models\BowComponentLocation;
use App\Models\ComponentManufacturer;
use App\Models\EllipticModel;
use App\Models\EllipticProduct;
use App\Models\User;
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

    public $ellipticProductModels;
    public ?EllipticModel $ellipticProductModel;
    public int $productModelId;

    public $ellipticProductsAvailable;
    public ?EllipticProduct $ellipticProduct;

    public $poolOwners;
    public int $pool_owner_id;
    public $bodiesOfWater;

    // Form Flags & Messaging
    public bool $showBack, $allow_edit, $create_new;
    public bool $saved, $readyToSave, $changed;
    public string $message;

    protected $rules = [
        'bowComponent.bodies_of_water_id' => 'exists:bodies_of_waters,id',
        'bowComponent.name' => 'string',
        'bowComponent.description' => 'string',
        'bowComponent.elliptic_product_id' => 'numeric|nullable',
        'bowComponent.manufacturer_id' => 'numeric|nullable',
        'bowComponent.installation_service_company_id' => 'numeric',
        'bowComponent.installation_service_ticket_id' => 'numeric',
        'bowComponent.installation_date' => 'date|nullable',
        'bowComponent.installation_location_id' => 'exists:bow_component_locations,id',
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

        $this->ellipticProductModels = EllipticModel::allActive();
        $this->productModelId = 0;
        $this->pool_owner_id = 0;
        if($this->bowComponent->id > 0) {
            if ($this->bowComponent->brand->is_elliptic_works) {
                $this->productModelId = $this->bowComponent->ellipticProduct->elliptic_model_id;
            }
            if ($this->bowComponent->bodyOfWater) {
                $this->pool_owner_id = $this->bowComponent->bodyOfWater->owner->id;
                $this->bodiesOfWater = BodiesOfWater::allForPoolOwnerId($this->pool_owner_id);
            }
        }
        $this->ellipticProductsAvailable = EllipticProduct::allAvailable();

        $this->poolOwners = User::allPoolOwners();
    }

    public function render(){
        debugbar()->info('render:ComponentForm');
        debugbar()->info($this->bowComponent->attributesToArray());
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
        debugbar()->info($this->productModelId);
        debugbar()->info($this->bowComponent->filled());

        $this->changed = true;

        if ($this->productModelId) {
            $this->ellipticProductsAvailable = EllipticProduct::allAvailableByModelId($this->productModelId);
            $this->ellipticProductModel = EllipticModel::find($this->productModelId);
        }

        $this->readyToSave = false;
        if($this->bowComponent->filled())
            $this->readyToSave = true;

        debugbar()->info($this->readyToSave);
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

        $this->ellipticProductModels = EllipticModel::allActive();
        $this->productModelId = 0;
        $this->pool_owner_id = 0;
        if($this->bowComponent->id > 0) {
            if ($this->bowComponent->brand->is_elliptic_works) {
                $this->productModelId = $this->bowComponent->ellipticProduct->elliptic_model_id;
            }
            if ($this->bowComponent->bodyOfWater) {
                $this->pool_owner_id = $this->bowComponent->bodyOfWater->owner->id;
                $this->bodiesOfWater = BodiesOfWater::allForPoolOwnerId($this->pool_owner_id);
            }
        }

        $this->ellipticProductsAvailable = EllipticProduct::allAvailable();

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
//        debugbar()->info($this->bowComponent->attributesToArray());
//        debugbar()->info($this->bowComponent->modelNumber());
//        debugbar()->info($this->bowComponent->serialNumber());



        try {
            $this->bowComponent->saveOrFail();
            debugbar()->info('bowComponent Saved');
            $this->saved = true;
            $this->changed = false;
            $this->message = "BoW Component Saved";
            $this->emit('message');
            if($this->bowComponent->ellipticProduct) {
                $this->bowComponent->ellipticProduct->pool_owner_id = $this->pool_owner_id;
                $this->bowComponent->ellipticProduct->saveOrFail();
                $this->message = "Elliptic Product Updated";
                $this->emit('message');
            }
        } catch (\Exception $e){
            $this->message = "Error Saving BoW Component... ".$e->getMessage();
            $this->emit('message');   // alpine JS $this.on('message',() => {}) event
        }
    }
}
