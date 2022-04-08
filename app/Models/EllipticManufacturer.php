<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EllipticManufacturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address_id',
        'contact',
        'phone_work',
        'email_work',
        'website_main_url',
    ];

    protected $casts = [];

    // default when new
    protected $attributes = [
        'name' => '',
        'description' => '',
        'address_id' => 0,
        'contact' => '',
        'phone_work' => '',
        'email_work' => '',
        'website_main_url' => '',
    ];

    // eager load relationships
    protected $with = [
        'address',
        ];

    // Eloquent Relationships
    public function address(){
        return $this->hasOne(Address::class, 'id', 'address_id');
    }
}
