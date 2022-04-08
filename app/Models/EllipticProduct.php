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
        'warranty_stated_on',
        'warranty_ends_on',
        'current_construction_version',
        'current_software_version',
        'installer_id',
        'removed_from_service_on',
    ];

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
        'warranty_stated_on' => null,
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
        return $this->hasOne(EllipticModel::class);
    }
    public function bumblebee(){
        return $this->hasOne(Bumblebee::class);
    }
    public function ellipticManufacturer(){
        return $this->hasOne(EllipticManufacturer::class);
    }
}
