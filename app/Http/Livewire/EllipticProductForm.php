<?php

namespace App\Http\Livewire;

use App\Models\Bumblebee;
use App\Models\EllipticManufacturer;
use App\Models\EllipticModel;
use App\Models\EllipticProduct;
use Livewire\Component;

class EllipticProductForm extends Component
{
    public ?EllipticProduct $ellipticProduct;

    public $ellipticModels, $ellipticBumblebees, $ellipticManufacturers;

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
    }

    public function render(){
        debugbar()->info('render:EllipticProductForm');
//        debugbar()->info($this->ellipticProduct->attributesToArray());
        return view('livewire.elliptic-product-form');
    }

    public function changed(){
        debugbar()->info('EllipticProductForm Changed');
        $this->changed = true;

        if($this->ellipticProduct->bumblebee) {
            debugbar()->info($this->ellipticProduct->bumblebee->attributesToArray());
        }
        if (strlen($this->ellipticProduct->current_construction_version) == 0)
            $this->ellipticProduct->current_construction_version = $this->ellipticProduct->manufacture_construction_version;
        if (strlen($this->ellipticProduct->current_software_version) == 0)
            $this->ellipticProduct->current_software_version = $this->ellipticProduct->manufacture_software_version;

        $this->readyToSave = false;
        if($this->ellipticProduct->filled())
            $this->readyToSave = true;
    }

    public function discard(){
        debugbar()->info('EllipticProductForm Discard');
        $this->emit('discardChanges');

        if($this->ellipticProduct->id)
            $this->ellipticProduct->refresh();
        else
            $this->ellipticProduct = new EllipticProduct();

        $this->readyToSave = false;
        $this->message = "Changes Discarded";
        $this->emit('message');
        $this->changed = false;
    }

    public function save(){
        debugbar()->info('Saving EllipticProductForm');

        // run validation rule
        $validatedData = $this->validate();

        try {
            $this->ellipticProduct->saveOrFail();
            debugbar()->info('EllipticProduct Saved');
            $this->saved = true;
            $this->changed = false;
            $this->message = "Elliptic ProductForm Saved";
            $this->emit('message');
        } catch (\Exception $e){
            $this->message = "Error Saving Elliptic Product... ".$e->getMessage();
            $this->emit('message');   // alpine JS $this.on('message',() => {}) event
        }
    }




}
