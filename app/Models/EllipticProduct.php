<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class EllipticProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'elliptic_model_id',
        'serial_number',
        'bumblebee_id',
        'elliptic_manufacturer_id',
        'manufactured_on',
        'manufacture_construction_version',
        'manufacture_software_version',
        'warranty_started_on',
        'warranty_ends_on',
        'current_construction_version',
        'current_software_version',
        'installer_id',
        'removed_from_service_on',
        'pool_owner_id',
        'bow_component_id',
    ];

    // eloquent private properties
    protected $privateProperties = []; // ?? https://stackoverflow.com/questions/40331167/how-do-i-make-a-property-private-in-a-laravel-eloquent-model

    protected $casts = [];

    // default when new
    protected $attributes = [
        'elliptic_model_id' => 0,
        'serial_number' => '',
        'bumblebee_id' => 0,
        'elliptic_manufacturer_id' => 0,
        'manufactured_on' => null,
        'manufacture_construction_version' => '',
        'manufacture_software_version' => '',
        'warranty_started_on' => null,
        'warranty_ends_on' => null,
        'current_construction_version' => '',
        'current_software_version' => '',
        'installer_id' => 0,
        'removed_from_service_on' => null,
    ];

    // eager load relationships
    protected $with = [];

    // Eloquent Relationships
    public function ellipticModel(){
        return $this->hasOne(EllipticModel::class, 'id', 'elliptic_model_id');
    }
    public function model(){
        return $this->hasOne(EllipticModel::class, 'id', 'elliptic_model_id');
    }
    public function bumblebee(){
        return $this->hasOne(Bumblebee::class, 'id', 'bumblebee_id');
    }
    public function ellipticManufacturer(){
        return $this->hasOne(EllipticManufacturer::class,'id', 'elliptic_manufacturer_id');
    }
    public function bowComponent(){
        return $this->belongsTo(BowComponent::class, 'id', 'elliptic_product_id');
    }
    public function bodyOfWater(){
        return $this->hasOneThrough(
            BodiesOfWater::class,
            BowComponent::class,
            'bodies_of_water_id',
            'id');
    }



    // METHODS

    public static function allAvailable(){
        return EllipticProduct::query()
            ->where('pool_owner_id', 0)
            ->where('removed_from_service_on', null)
            ->orderBy('elliptic_model_id', 'asc')
            ->orderBy('serial_number', 'asc')
            ->get();
    }
    public static function allAvailableByModelId(int $modelID){
        return EllipticProduct::query()
            ->where('pool_owner_id', 0)
            ->where('removed_from_service_on', null)
            ->where('elliptic_model_id', $modelID)
            ->orderBy('elliptic_model_id', 'asc')
            ->orderBy('serial_number', 'asc')
            ->get();
    }
    public static function allOwnedByUser(User $user){
        return self::allOwnedByUserId($user->id);
    }
    public static function allOwnedByUserId(int $userID){
        return EllipticProduct::query()
            ->where('pool_owner_id', $userID)
            ->orderBy('elliptic_model_id', 'asc')
            ->orderBy('serial_number', 'asc')
            ->get();
    }
    public static function allBumblebeesOwnedByUserId(int $userID){
        return EllipticProduct::query()
            ->where('pool_owner_id', $userID)
            ->where('bumblebee_id', '>', 0)
            ->orderBy('elliptic_model_id', 'asc')
            ->orderBy('serial_number', 'asc')
            ->get();
    }

    public function owner(){
        if ($this->pool_owner_id) {
            return $this->hasOne(
                User::class,
                'id',
                'pool_owner_id');
        }
        if ($this->bowComponent)
            return $this->bowComponent->bodyOfWater->owner;
        if($this->$this->bodyOfWater)
            return $this->bodyOfWater->owner;

        return null;
    }
    /**
     * Get the Serial Number of the Elliptic Product
     * @return mixed|string
     */
    public function serialNumber(){
        if($this->bumblebee){
            return $this->bumblebee->serial_number;
        }
        return $this->serial_number;
    }

    public function filled(){

        if ($this->bumblebee){
            return ($this->elliptic_model_id > 0
            && $this->elliptic_manufacturer_id > 0
            && strlen($this->manufacture_construction_version) > 4
            && strlen($this->manufacture_software_version) > 4
            && strlen($this->current_construction_version) > 4
            && strlen($this->current_software_version) > 4);
        }
        return (
            $this->elliptic_model_id > 0
            && strlen($this->serial_number) > 4
            && $this->elliptic_manufacturer_id > 0
            && strlen($this->manufacture_construction_version) > 4
            && strlen($this->manufacture_software_version) > 4
            && strlen($this->current_construction_version) > 4
            && strlen($this->current_software_version) > 4
        );
    }
}
