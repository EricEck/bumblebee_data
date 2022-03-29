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

    // Eloquent Relationships
    public function bodyOfWater(){
        return $this->hasOne(BodiesOfWater::class, 'id', 'bodies_of_water_id');
    }
    public function componentLocation(){
        return $this->hasOne(BowComponentLocation::class);
    }
}
