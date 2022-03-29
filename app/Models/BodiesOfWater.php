<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodiesOfWater extends Model
{
    use HasFactory;

    protected $fillable = [
        'pool_owner_id',
        'description_pool',
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

    // Eloquent Relationships
    public function owner(){
        return $this->hasOne(PoolOwner::class, 'id', 'pool_owner_id');
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

}
