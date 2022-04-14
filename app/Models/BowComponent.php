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
        'bodies_of_water_id' => 0,
        'name' => '',
        'description' => '',
        'elliptic_product_id' => 0,
        'manufacturer_id' => 0,
        'installation_service_company_id' => 0,
        'installation_service_ticket_id' => 0,
        'installation_date' => null,
        'installation_location_id' => 0,
        'installed_now' => 0,
        'warranty' => 0,
        'warranty_end_date'=> null,
        'model_number'=> '',
        'serial_number'=> '',
        'removed_from_service_date'=> null,
        'removed_from_service_ticket_id'=> 0,
    ];


    // Eloquent Relationships
    public function bodyOfWater(){
        return $this->belongsTo(BodiesOfWater::class, 'bodies_of_water_id', 'id');
    }
    public function componentLocation(){
        return $this->hasOne(BowComponentLocation::class, 'id', 'installation_location_id');
    }
    public function ellipticProduct(){
        return $this->hasOne(EllipticProduct::class, 'id', 'elliptic_product_id');
    }
    public function brand(){
        return $this->hasOne(ComponentManufacturer::class, 'id', 'manufacturer_id');
    }


    // METHODS
    public function serialNumber(){
        if ($this->brand->is_elliptic_works){
            return $this->ellipticProduct->serialNumber();
        }
        return $this->serial_number;
    }
    public function modelNumber(){
        if ($this->brand->is_elliptic_works){
            return $this->ellipticProduct->model->name;
        }
        return $this->model_number;
    }
    public function manufacturer(){
        if ($this->brand->is_elliptic_works) {
            return $this->ellipticProduct->ellipticManufacturer;
        }
        return $this->brand;
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
        if ($this->brand && $this->brand->is_elliptic_works){
            return (
                $this->bodies_of_water_id > 0
                && $this->manufacturer_id > 0
                && $this->ellipticProduct
                && $this->ellipticProduct->id > 0
            );
        }
        return (
            $this->bodies_of_water_id > 0
            && $this->manufacturer_id > 0
            && strlen($this->model_number) > 0
            && strlen($this->serial_number) > 0
        );
    }
}
