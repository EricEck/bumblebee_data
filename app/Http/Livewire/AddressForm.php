<?php

namespace App\Http\Livewire;

use App\Models\Address;
use App\Models\Country;
use Livewire\Component;

class AddressForm extends Component
{
    public Address $address;

    public  $countries = array();

    public bool $childForm = false;
    public string $addressName = "";
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

    // Event Listeners - Livewire
    protected $listeners = [
        'discardChanges' => 'discard',
        ];

    public function mount(){
        debugbar()->info('Mounting Address Form');
        $this->countries = Country::all();
        if (!$this->address->id)
            $this->address->country_id = Country::findByName('USA')[0]->id;
        $this->changed = false;
    }

    public function render(){
        debugbar()->info('Rendering Address Form ID: '. $this->address->id);
//        debugbar()->info('Allow Edit: '.$this->allow_edit);
//        debugbar()->info($this->address->attributesToArray());
        return view('livewire.address-form');
    }

    public function changed(){
        $this->changed = true;

        $this->emitUp('addressChanged', $this->address->attributesToArray());

        if ($this->address->filled()){
            $this->message = "Address Complete...";
            $this->emit('message');

            if($this->address->findForwardGeoCode()){
                $this->message = "Found latitude/longitude!";
                $this->emit('message');
                $this->emitUp('addressChanged', $this->address->attributesToArray());
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
        $this->emitUp('clearAddress');
    }


    /**
     * Save or Update the Address if not a child form
     * @return void
     */
    public function save(){
        if(!$this->childForm) {
            debugbar()->info('Saving Address');
            debugbar()->info($this->address->attributesToArray());
            try {
                $this->address->saveOrFail();
                $this->message = "Address Saved";
                $this->emit('message');
                $this->changed = false;
            } catch (\Exception $e) {

                $this->message = "Error Saving Address... " . $e->getMessage();
                $this->emit('message');
                debugbar()->info('Error Saving Address...');
                debugbar()->error($e);
            }
        }
    }
}
