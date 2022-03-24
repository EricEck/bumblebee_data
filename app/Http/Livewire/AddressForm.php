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

    protected $rules =[
        'address.street_1' => 'required|string|max:127',
        'address.street_2' => 'string|max:127',
        'address.street_3' => 'string|max:127',
        'address.city' => 'required|string|max:127',
        'address.state_id' => 'required|numeric|exists:states,id',
        'address.country_id' => 'required|numeric|exists:countries,id',
        'address.latitude' => 'numeric',
        'address.longitude' => 'numeric',
    ];

    public function mount(){
        debugbar()->info('Mounting Address Form');
        $this->countries = Country::findByName('USA');
        $this->address->country_id = $this->countries[0]->id;
        $this->address->state_id = 0;
    }
    public function render(){
        debugbar()->info('Rendering Address Form');
        debugbar()->info('Allow Edit: '.$this->allow_edit);
        debugbar()->info($this->address->attributesToArray());
        return view('livewire.address-form');
    }

    public function save(){
        debugbar()->info('Saving Address');
        debugbar()->info($this->address->attributesToArray());
    }
}
