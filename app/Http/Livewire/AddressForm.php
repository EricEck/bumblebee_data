<?php

namespace App\Http\Livewire;

use App\Models\Address;
use App\Models\Country;
use Livewire\Component;

class AddressForm extends Component
{
    public Address $address;

    public  $countries = array();

    public bool $allow_edit;
    public bool $changed;
    public string $message;

    protected $rules =[
        'address.street_1' => 'required|string|max:127',
        'address.street_2' => 'string|max:127',
        'address.street_3' => 'string|max:127',
        'address.city_name' => 'required|string|max:127',
        'address.state_id' => 'required|numeric|exists:states,id',
        'address.postal_code' => 'required|string',
        'address.country_id' => 'required|numeric|exists:countries,id',
        'address.latitude' => 'numeric',
        'address.longitude' => 'numeric',
    ];

    public function mount(){
        debugbar()->info('Mounting Address Form');
        $this->countries = Country::findByName('USA');
        $this->address->country_id = $this->countries[0]->id;
        $this->countries[0]->states;
        $this->address->state_id = 0;
        $this->changed = false;
    }
    public function render(){
        debugbar()->info('Rendering Address Form');
        debugbar()->info('Allow Edit: '.$this->allow_edit);
        debugbar()->info($this->address->attributesToArray());
        return view('livewire.address-form');
    }

    public function changed(){
        $this->changed = true;
        if ($this->address->filled()){
            $this->message = "Searching for latitude/longitude...";
            $this->emit('message');
            if($this->address->findForwardGeoCode()){
                $this->message = "Found latitude/longitude";
                $this->emit('message');
            }
        }
    }

    /**
     * Discard the Changes to this Address
     * @return void
     */
    public function discard(){
        debugbar()->info('Discard');
        if($this->address->id > 0){
            $this->address->refresh();
        } else {
            $this->address = new Address();
            $this->address->country_id = $this->countries[0]->id;
            $this->address->state_id = 0;
        }
        $this->message = "Changes Discarded";
        $this->emit('message');
        $this->changed = false;
    }


    /**
     * Save or Update the Address
     * @return void
     */
    public function save(){
        debugbar()->info('Saving Address');
        debugbar()->info($this->address->attributesToArray());

        $this->message = "Address Saved";
        $this->emit('message');
        $this->changed = false;

    }
}
