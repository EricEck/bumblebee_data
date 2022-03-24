<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'latitude',
        'longitude',
    ];

    protected $casts = [
    ];

    // eager load
    protected $with = [];

    // Eloquent Relationships
    public function states(){
        return $this->hasMany(State::class);
    }


    /**
     * @param string $name
     * @return Country[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function findByName(string $name){
        return Country::query()
            ->where('name', 'like', '%'.$name.'%')
            ->orWhere('short_name', 'like', '%'.$name.'%')
            ->get();
    }
}
