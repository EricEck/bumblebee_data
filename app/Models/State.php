<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'country_id',
        'latitude',
        'longitude',
    ];

    protected $casts = [
    ];

    // eager load
    protected $with = [];

    //
    // Eloquent Relationships
    //
    public function country(){
        return $this->belongsTo(Country::class);
    }

    /**
     * @param string $name
     * @return State[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function findByName(string $name){
        return State::query()
            ->where('name', 'like', '%'.$name.'%')
            ->orWhere('short_name', 'like', '%'.$name.'%')
            ->get();
    }

}
