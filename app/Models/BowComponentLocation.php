<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BowComponentLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'bodies_of_water_id',
        ];

    protected $attributes = [
        'name' => '',
        'description' => '',
        'bodies_of_water_id' => '0',
    ];

    // Eloquent Relationships

    public function components(){
        return $this->hasMany(BowComponent::class, 'installation_location_id', 'id');
    }
    public function bodyOfWater(){
        return $this->hasOne(BodiesOfWater::class);
    }

    // METHODS

    public function filled(){
        return (
            strlen($this->name) > 5
        );
    }

    /**
     * All Locations for a Body of Water
     * @param $bow_id
     * @return BowComponentLocation[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public static function allForBodyOfWaterId($bow_id){
        return BowComponentLocation::query()
            ->where('bodies_of_water_id', $bow_id)
            ->orderBy('name')
            ->get();
    }
}
