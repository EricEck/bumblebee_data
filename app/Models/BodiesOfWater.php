<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodiesOfWater extends Model
{
    use HasFactory;

    protected $fillable = [
        'pool_owner_id',
        'name',
        'description_pool',
        'address_id',
        'location_type_id',
        'description_access',
        'latitude',
        'longitude',
        'filtration_type_id',
        'filteration_share_with_bow_id',
        'construction_type_id',
        'description_construction',
        'construction_date',
        'commercial',
        'indoor',
        'gallons',
    ];

    // Default attribute values when created
    protected $attributes = [
        'pool_owner_id' => 0,
        'name' => '',
        'description_pool' => '',
        'location_type_id' => 0,
        'filtration_type_id' => 0,
        'filteration_share_with_bow_id' => 0,
        'construction_type_id' => 0,
        'description_construction' => '',
        'latitude' => 0.0,
        'longitude' => 0.0,
        'gallons' => 0,
        'commercial' => 0,
        'indoor' => 0,

    ];

    // Eloquent Relationships
    public function owner(){
        return $this->hasOne(User::class, 'id', 'pool_owner_id');
    }
    public function address(){
        return $this->hasOne(Address::class, 'id', 'address_id');
    }
    public function bowLocationType(){
        return $this->hasOne(BowLocationType::class, 'id', 'location_type_id');
    }
    public function bowFiltrationType(){
        return $this->hasOne(FiltrationType::class, 'id', 'filtration_type_id');
    }
    public function bowConstructionType(){
        return $this->hasOne(ConstructionType::class, 'id', 'filtration_type_id');
    }
    public function components(){
        return $this->hasMany(BowComponent::class, 'bodies_of_water_id', 'id');
    }

    public function filled(){
        return (
            $this->pool_owner_id > 0
            && strlen($this->name) > 5
            && $this->address_id > 0
            && $this->location_type_id > 0
            && $this->filtration_type_id > 0
            && $this->construction_type_id > 0
        );
    }


}
