<?php

namespace App\Http\Livewire;

use App\Models\BodiesOfWater;
use App\Models\BowComponent;
use App\Models\BowComponentLocation;
use App\Models\Bumblebee;
use App\Models\EllipticManufacturer;
use App\Models\EllipticModel;
use App\Models\EllipticProduct;
use App\Models\User;
use Livewire\Component;

class EllipticProductForm extends Component
{
    public ?EllipticProduct $ellipticProduct;

    public $ellipticModels, $ellipticBumblebees, $ellipticManufacturers;
    public $poolOwners, $bodiesOfWater;
    public $bowComponents, $bowComponent;

    public $bow_id, $bow_component_id, $pool_owner_id;

    // form flags
    public bool $showBack, $allow_edit, $create_new;
    public bool $saved, $readyToSave, $changed;
    public string $message;

    protected $rules = [
        'ellipticProduct.elliptic_model_id' => 'exists:elliptic_models,id',
        'ellipticProduct.serial_number' => 'string|min:4',
        'ellipticProduct.bumblebee_id' => 'numeric',
        'ellipticProduct.elliptic_manufacturer_id' => 'exists:elliptic_manufacturers,id',
        'ellipticProduct.manufactured_on' => 'nullable|date',
        'ellipticProduct.manufacture_construction_version' => 'string|min:4',
        'ellipticProduct.manufacture_software_version' => 'string|min:4',
        'ellipticProduct.warranty_started_on' => 'nullable|date',
        'ellipticProduct.warranty_ends_on' => 'nullable|date',
        'ellipticProduct.current_construction_version' => 'string|min:4',
        'ellipticProduct.current_software_version' => 'string|min:4',
        'ellipticProduct.installer_id' => 'numeric',
        'ellipticProduct.removed_from_service_on' => 'nullable|date',
        'ellipticProduct.pool_owner_id' => 'numeric',
        'ellipticProduct.bow_component_id' => 'numeric',
    ];

    protected $casts = [];

    // Event Listeners - Livewire
    protected $listeners = [
    ];

    public function mount(){
        debugbar()->info('mount:EllipticProductForm');

        $this->ellipticModels = EllipticModel::all();
        $this->ellipticBumblebees = Bumblebee::all();
        $this->ellipticManufacturers = EllipticManufacturer::all();
        $this->poolOwners = User::allPoolOwners();
        $this->bowComponents = BowComponent::all();

        if ($this->create_new){
            // NEw Elliptic Product
            $this->bowComponent = new BowComponent();
            $this->bow_component_id = 0;
            $this->bow_id = 0;
            $this->pool_owner_id = 0;
            $this->bodiesOfWater = BodiesOfWater::all();

        } else {
            // Existing Elliptic Product
            $this->bow_component_id = 0;
            $this->bow_id = 0;
            $this->pool_owner_id = 0;
            if($this->ellipticProduct->bowComponent != null) {
                $this->bowComponent = $this->ellipticProduct->bowComponent;
                $this->bow_component_id = $this->bowComponent->id;
                $this->bow_id = $this->bowComponent->bodies_of_water_id;
            }

            if ($this->ellipticProduct && $this->ellipticProduct->pool_owner_id > 0) {
                $this->pool_owner_id = $this->ellipticProduct->pool_owner_id;
                $this->bodiesOfWater = BodiesOfWater::allForPoolOwnerId($this->ellipticProduct->pool_owner_id);
            }
            else
                $this->bodiesOfWater = BodiesOfWater::all();
        }

    }

    public function render(){
        debugbar()->info('render:EllipticProductForm');
        return view('livewire.elliptic-product-form');
    }

    public function changed($what = ''){
        debugbar()->info('EllipticProductForm Changed: '.$what);

        $this->changed = true;

        switch($what) {
            case('pool_owner_id'):
                $this->bodiesOfWater = BodiesOfWater::allForPoolOwnerId($this->pool_owner_id);
                $this->bow_id = 0;
                if(count($this->bodiesOfWater))
                    $this->bow_id = $this->bodiesOfWater[0]->id;
                break;

            case('bow_id'):
                break;
        }

        if (strlen($this->ellipticProduct->current_construction_version) == 0)
            $this->ellipticProduct->current_construction_version = $this->ellipticProduct->manufacture_construction_version;
        if (strlen($this->ellipticProduct->current_software_version) == 0)
            $this->ellipticProduct->current_software_version = $this->ellipticProduct->manufacture_software_version;

        $this->readyToSave = false;
        if($this->ellipticProduct->filled()) {
            $this->readyToSave = true;
        }

    }

    public function discard()
    {
        debugbar()->info('EllipticProductForm Discard');
        $this->emit('discardChanges');

        if ($this->ellipticProduct->id) {
            $this->ellipticProduct->refresh();
            $this->create_new = false;
        }
        else
            $this->ellipticProduct = new EllipticProduct();

        if ($this->create_new){
            // NEw Elliptic Product
            $this->bowComponent = new BowComponent();
            $this->bow_component_id = 0;
            $this->bow_id = 0;
            $this->pool_owner_id = 0;
            $this->bodiesOfWater = BodiesOfWater::all();

        } else {
            // Existing Elliptic Product
            $this->bow_component_id = 0;
            $this->bow_id = 0;
            $this->pool_owner_id = 0;
            if($this->ellipticProduct->bowComponent != null) {
                $this->bowComponent = $this->ellipticProduct->bowComponent;
                $this->bow_component_id = $this->bowComponent->id;
                $this->bow_id = $this->bowComponent->bodies_of_water_id;
            }

            if ($this->ellipticProduct && $this->ellipticProduct->pool_owner_id > 0) {
                $this->pool_owner_id = $this->ellipticProduct->pool_owner_id;
                $this->bodiesOfWater = BodiesOfWater::allForPoolOwnerId($this->ellipticProduct->pool_owner_id);
            }
            else
                $this->bodiesOfWater = BodiesOfWater::all();
        }

        $this->readyToSave = false;
        $this->message = "Changes Discarded";
        $this->emit('message');
        $this->changed = false;
    }

    public function save(){
        debugbar()->info('Saving EllipticProductForm');

        // run validation rule
        $validatedData = $this->validate();

        // save the bowComponent First

        try {
            $this->bowComponent->bodies_of_water_id = $this->bow_id;
            $this->bowComponent->saveOrFail();
            debugbar()->info('bowComponent Saved');
            $this->message = "BoW Component Saved";
            $this->emit('message');
            $this->bow_component_id = $this->bowComponent->id;

        } catch (\Exception $e){
            $this->message = "Error Saving BoW Component... ".$e->getMessage();
            $this->emit('message');   // alpine JS $this.on('message',() => {}) event
        }

        try {
            $this->ellipticProduct->pool_owner_id = $this->pool_owner_id;
            $this->ellipticProduct->saveOrFail();
            debugbar()->info('EllipticProduct Saved');
            $this->saved = true;
            $this->create_new = false;
            $this->changed = false;
            $this->message = "Elliptic ProductForm Saved";
            $this->emit('message');
        } catch (\Exception $e){
            $this->message = "Error Saving Elliptic Product... ".$e->getMessage();
            $this->emit('message');   // alpine JS $this.on('message',() => {}) event
        }
    }

}
