<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BowComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'bodies_of_water_id',
        'name',
        'description',
        'elliptic_product_id',
        'manufacturer_id',
        'installation_service_company_id',
        'installation_service_ticket_id',
        'installation_date',
        'installation_location_id',
        'installed_now',
        'warranty',
        'warranty_end_date',
        'model_number',
        'serial_number',
        'removed_from_service_date',
        'removed_from_service_ticket_id',
    ];

    // automatically filled on new
    protected $attributes = [
        'bodies_of_water_id' => '0',
        'name' => '',
        'description' => '',
        'elliptic_product_id' => -1,
        'manufacturer_id' => -1,
        'installation_service_company_id' => null,
        'installation_service_ticket_id' => null,
        'installation_date' => null,
        'installation_location_id' => -1,
        'installed_now' => 0,
        'warranty' => 0,
        'warranty_end_date'=> null,
        'model_number'=> '',
        'serial_number'=> '',
        'removed_from_service_date'=> null,
        'removed_from_service_ticket_id'=> null,
    ];


    // Eloquent Relationships
    public function bodyOfWater(){
        return $this->hasOne(BodiesOfWater::class, 'id', 'bodies_of_water_id');
    }
    public function componentLocation(){
        return $this->hasOne(BowComponentLocation::class, 'id', 'installation_location_id');
    }


    /**
     * Return all Components for a Body of Water ID
     * @param int $bow_id
     * @return BowComponent[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function whereBowId(int $bow_id){
        return BowComponent::where('bodies_of_water_id', $bow_id)
            ->get();
    }

    public function filled(){
        return false;
    }
}
