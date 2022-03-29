<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoolOwner extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'billing_same_as_address',
        'billing_address_id',
        'primary_owner',
        'primary_owner_id',
    ];

    // Eloquent Relationships
    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function billingAddress()
    {
        return $this->hasOne(Address::class, 'id', 'billing_address_id');
    }
    public function primaryOwner(){
        return $this->hasOne(User::class);
    }
    public function bodiesOfWater(){
        return $this->hasMany(BodiesOfWater::class, 'pool_owner_id', 'id');
    }

}
