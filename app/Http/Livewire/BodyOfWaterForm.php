<?php

namespace App\Http\Livewire;

use App\Models\Address;
use App\Models\BodiesOfWater;
use App\Models\BowLocationType;
use App\Models\ConstructionType;
use App\Models\FiltrationType;
use App\Models\PoolOwner;
use App\Models\User;
use Livewire\Component;

class BodyOfWaterForm extends Component
{
    public BodiesOfWater $bodyOfWater;

    public $primaryOwnersList, $addresses, $locationTypes, $filtrationTypes, $constructionTypes;
    public User $owner;
    public Address $address;
    public bool $createNewAddress;

    public bool $allow_edit;
    public bool $create_new;
    public bool $showBack = false;

    public bool $saved;
    public bool $readyToSave;
    public bool $changed;

    public string $message;

    protected $rules = [
        'bodyOfWater.pool_owner_id' => 'exists:users,id',
        'bodyOfWater.name' => 'required|min:4|max:45',
        'bodyOfWater.description_pool' => 'string|max:1024',
        'bodyOfWater.address_id' => 'required|exists:addresses,id',
        'bodyOfWater.location_type_id' => 'required|exists:bow_location_types,id',
        'bodyOfWater.description_access' => 'string|max:512',
        'bodyOfWater.latitude' => 'numeric',
        'bodyOfWater.longitude' => 'numeric',
        'bodyOfWater.filtration_type_id' => 'required|exists:filtration_types,id',
        'bodyOfWater.filteration_share_with_bow_id' => 'numeric',
        'bodyOfWater.construction_type_id' => 'required|exists:construction_types,id',
        'bodyOfWater.description_construction' => 'string|max:1024',
        'bodyOfWater.construction_date' => 'date',
        'bodyOfWater.commercial' => 'boolean',
        'bodyOfWater.indoor' => 'boolean',
        'bodyOfWater.gallons' => 'numeric',
    ];

    protected $casts = [];

    // Event Listeners - Livewire
    protected $listeners = [];


    public function mount(){
        debugbar()->info('Mounting BoW Form');

        $this->primaryOwnersList = PoolOwner::allPrimary();

        $this->owner = new User();

        $this->addresses = Address::all();
        $this->address = new Address();
        $this->createNewAddress = false;

        $this->locationTypes = BowLocationType::where('id', '>', '0')->orderBy('order')->get();
        $this->filtrationTypes = FiltrationType::where('id', '>', '0')->orderBy('order')->get();
        $this->constructionTypes = ConstructionType::where('id', '>', '0')->orderBy('order')->get();

        if($this->create_new){
            $this->bodyOfWater = new BodiesOfWater();
        } else {
            $this->owner = User::find($this->bodyOfWater->pool_owner_id);
            $this->address = Address::find($this->bodyOfWater->address_id);
        }
    }

    public function render(){
        debugbar()->info('Rendering BoW Form');

        ($this->bodyOfWater->commercial == true) ?
            $this->bodyOfWater->commercial = 1
            : $this->bodyOfWater->commercial = 0;

        ($this->bodyOfWater->indoor == true) ?
            $this->bodyOfWater->indoor = 1
            : $this->bodyOfWater->indoor = 0;


        debugbar()->info($this->bodyOfWater->location_type_id);
        return view('livewire.body-of-water-form');
    }

    public function changed(){
        debugbar()->info('BoW Form Changed');
        $this->changed = true;

        // set the default address = owner's address
        if ($this->bodyOfWater->pool_owner_id && $this->owner->id != $this->bodyOfWater->pool_owner_id){
            $this->owner = User::find($this->bodyOfWater->pool_owner_id);

            $this->bodyOfWater->address_id = -1;
            if($this->owner->address_home_id){
                $this->bodyOfWater->address_id = $this->owner->address_home_id;
                if($this->bodyOfWater->address->latitude && $this->bodyOfWater->address->longitude){
                    $this->bodyOfWater->latitude = $this->bodyOfWater->address->latitude;
                    $this->bodyOfWater->longitude = $this->bodyOfWater->address->longitude;
                }
            }
        }

        if ($this->bodyOfWater->address_id == -1 && !$this->createNewAddress){
            $this->createNewAddress = true;
            $this->address = new Address();
        }

        $this->readyToSave = false;
        if($this->bodyOfWater->filled())
            $this->readyToSave = true;
    }

    public function discard(){
        debugbar()->info('Discard');
        $this->emit('discardChanges');

        if($this->bodyOfWater->id > 0){
            $this->bodyOfWater->refresh();
            $this->owner = User::find($this->bodyOfWater->pool_owner_id);
            $this->address = Address::find($this->bodyOfWater->address_id);
        } else {
            $this->bodyOfWater = new BodiesOfWater();
            $this->owner = new User();
            $this->address = new Address();
        }

        $this->createNewAddress = false;
        $this->readyToSave = false;
        $this->message = "Changes Discarded";
        $this->emit('message');
        $this->changed = false;
    }

    public function save(){
        debugbar()->info('Saving Body of Water');

        $this->bodyOfWater->commercial == true ?
            $this->bodyOfWater->commercial = true
            : $this->bodyOfWater->commercial = false;

        $this->bodyOfWater->indoor == true ?
            $this->bodyOfWater->indoor = true
            : $this->bodyOfWater->indoor = false;

        // run validation rule
        $validatedData = $this->validate();
        try {
            $this->bodyOfWater->saveOrFail();
            debugbar()->info('BoW Saved');
            $this->saved = true;
            $this->changed = false;
            $this->message = "Body of Water Saved";
            $this->emit('message');
        } catch (\Exception $e){
            $this->message = "Error Saving BoW... ".$e->getMessage();
            $this->emit('message');   // alpine JS $this.on('message',() => {}) event
        }
    }

}
