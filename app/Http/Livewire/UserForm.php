<?php

namespace App\Http\Livewire;

use App\Models\Address;
use App\Models\EllipticMember;
use App\Models\PoolOwner;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;


class UserForm extends Component
{
    public User $user;

    public bool $allow_edit;
    public bool $create_new;
    public bool $showBack = false;

    public bool $saved;
    public bool $readyToSave;
    public bool $changed;

    public string $message;

    public Address $addressHome, $addressBilling;
    public array $addressToSave;
    public bool $addressChanged;

    public $roles;

    public ?PoolOwner $poolOwner;
    public $ownersList;

    public ?EllipticMember $ellipticMember;     // php 7.1+ allows for null return


    protected $rules =[
        'user.name' => 'required|min:5|max:100',
        'user.email' => 'required|email:rfc,dns',
        'user.phone_mobile' => 'string|max:45',
        'user.phone_home' => 'string|max:45',
        'user.phone_office' => 'string|max:45',
        'roles.*.is' => 'required',
        'poolOwner.user_id' => 'numeric',
        'poolOwner.billing_same_as_address' => 'numeric',
        'poolOwner.billing_address_id' => 'numeric',
        'poolOwner.is_primary_owner' => 'numeric',
        'poolOwner.primary_owner_id' => 'numeric',
        'ellipticMember.user_id' => 'numeric',
        'ellipticMember.active' => 'numeric',
    ];

    protected $casts = [
        'roles' => 'array',
    ];

    // Event Listeners - Livewire
    protected $listeners = [
        'addressChanged',
        'clearAddress' => 'getResetAddress',
    ];

    public function mount(){

        debugbar()->info('Mounting User Form');

        $this->addressBilling = new Address();

        $this->ownersList = PoolOwner::all();

        $this->poolOwner = new PoolOwner([
            'user_id' => $this->user->id,
            'billing_same_as_address' => 1,
            'billing_address_id' => $this->user->address_home_id,
            'is_primary_owner' => 1,
            'primary_owner_id' => $this->user->id,
        ]);
        if($this->user->hasRole('pool-owner')){
            $this->poolOwner = PoolOwner::findOwner($this->user->id);
            if(!$this->poolOwner){
                $this->poolOwner = new PoolOwner([
                    'user_id' => $this->user->id,
                    'billing_same_as_address' => 1,
                    'billing_address_id' => $this->user->address_home_id,
                    'is_primary_owner' => 1,
                    'primary_owner_id' => $this->user->id,
                ]);
                $this->poolOwner->saveOrFail();
            }
            if($this->poolOwner->is_primary_owner){
                $this->addressBilling = Address::find($this->poolOwner->billing_address_id);
            }
        }

        $this->ellipticMember = new EllipticMember([
            'user_id' => $this->user->id,
            'active' => 0,
        ]);
        if($this->user->hasRole('elliptic_member')){
            $this->ellipticMember = EllipticMember::findMember($this->user->id);
            if($this->ellipticMember === null){
                $this->ellipticMember = new EllipticMember([
                    'user_id' => $this->user->id,
                    'active' => 1,
                ]);
                $this->ellipticMember->saveOrFail();
            }
        }

        $this->changed = false;
        $this->addressChanged = false;
        $this->readyToSave = false;
        $this->saved = false;

        $this->getResetAddress();
        $this->addressToSave = [];

        $this->getResetRoles();
    }
    /**
     * Render the View from the Model
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        debugbar()->info('Rendering User Form');
        return view('livewire.user-form');
    }

    public function changed(){
        $this->changed = true;
        debugbar()->info('User Form Changed');
        debugbar()->info($this->user->filled());
        if($this->user->filled()){
            $this->readyToSave = true;
        } else {
            $this->readyToSave = false;
        }
    }

    public function addressChanged($addressArray){

        $this->addressChanged = true;
        $this->addressToSave = $addressArray;
        $this->changed();
    }

    public function getResetAddress(){
        $this->addressChanged = false;
        $this->addressHome = Address::find($this->user->address_home_id) ?? new Address();
    }

    public function getResetRoles(){
        $this->roles = Role::all();

        foreach ($this->roles as $role){
            $role->is = 0;
            if($this->user->hasRole($role->name)){
                $role->is = 1;
            }
        }
    }

    public function discard(){
        debugbar()->info('Discard');
        $this->emit('discardChanges');

        if($this->user->id > 0){
            $this->user->refresh();
        } else {
            $this->user = new User();
        }
        if($this->user->hasRole('pool-owner')){
            $this->poolOwner = PoolOwner::findOwner($this->user->id);
        } else
            $this->poolOwner = new PoolOwner();

        $this->getResetAddress();
        $this->getResetRoles();

        $this->message = "Changes Discarded";
        $this->emit('message');
        $this->changed = false;
    }

    /**
     * Save using the validation and Model
     * @return void
     */
    public function save()
    {
        debugbar()->info('Saving User');
        // Update/Create the Address
        $this->addressHome = new Address($this->addressToSave);
        if($this->addressHome->filled()){
            try {
                $this->addressHome->saveOrFail();
                $this->user->address_home_id = $this->addressHome->id;
                debugbar()->info('Address Saved ID: '.$this->user->address_home_id);
            } catch (\Exception $e){
                $this->message = "Error Saving Address... ".$e->getMessage();
                $this->emit('message');
                debugbar()->info('Error Saving Address...');
                debugbar()->error($e);
            }
        }


        // run User validation rule
        $validatedData = $this->validate();

        // Save/Create the User
        try {
            $this->user->saveOrFail();
            debugbar()->info('user saved!');
            $this->saved = true;
            $this->changed = false;
            $this->message = "User Saved";
            $this->emit('message');
        } catch (\Exception $e){
            $this->message = "Error Saving User... ".$e->getMessage();
            $this->emit('message');   // alpine JS $this.on('message',() => {}) event
            debugbar()->info('Error Saving User...');
            debugbar()->error($e);
        }

        // Save/Update the User's Roles
        debugbar()->info('Save Roles...');
        foreach ($this->roles as $role){
            debugbar()->info($role->name);
            debugbar()->info($role->is);
            $this->user->detachRole($role->name);   // detach the role first to keep integrity
            if($role->is){
                $this->user->attachRole($role->name);
            }
        }

        // link pool owner table if needed
        if ($this->user->hasRole('pool-owner')){
            if(!PoolOwner::findOwner($this->user->id)){
                $this->poolOwner = new PoolOwner([
                    'user_id' => $this->user->id,
                    'is_primary_owner' => 1,
                    'primary_owner_id' => $this->user->id,
                    'billing_address_id' => $this->user->address_home_id,
                ]);
                try {
                    $this->poolOwner->saveOrFail();
                    $this->message = "Pool Owner Created";
                    $this->emit('message');
                } catch (\Exception $e){
                    $this->message = "Error Making User Pool Owner... ".$e->getMessage();
                    $this->emit('message');   // alpine JS $this.on('message',() => {}) event
                    $this->user->detachRole('pool-owner');
                }
            }

            if($this->poolOwner->billing_same_as_address){
                $this->poolOwner->billing_address_id = $this->user->address_home_id;
                $this->poolOwner->saveOrFail();
            }
        }
    }

}
