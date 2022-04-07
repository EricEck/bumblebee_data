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
        'is_primary_owner',
        'primary_owner_id',
    ];

    // Set default values
    protected $attributes = [
        'billing_same_as_address' => 1,
        'billing_address_id' => 0,
        'is_primary_owner' => 0,
        'primary_owner_id' => 0,
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
    public function commonOwners(){
        return $this->hasMany(PoolOwner::class, 'id', 'primary_owner_id');
    }

    /**
     * Find and Return an Owner by User ID
     * @param $user_id
     * @return PoolOwner|\Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function findOwner($user_id){
        return PoolOwner::query()
            ->where('user_id', $user_id)
            ->first();
    }



}
