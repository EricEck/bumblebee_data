<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable =[
        'street_1',
        'street_2',
        'street_3',
        'city_name',
        'state_id',
        'country_id',
        'postal_code',
        'latitude',
        'longitude',
        ];

    protected $casts = [
        ];

    // eager load
    protected $with = [
        'city',
        'state',
        'country'
    ];

    //
    // Eloquent Relationships
    //
    public function state(){
        return $this->belongsTo(State::class);
    }
    public function country(){
        return $this->belongsTo(State::class);
    }

    /**
     * Make a new Address and Save it to the DB
     *
     * @param string $s1
     * @param string $s2
     * @param string $s3
     * @param string $cityName
     * @param int $stateID
     * @param int $countryID
     * @param string $postalCode
     * @param float $lng
     * @param float $lat
     * @return Address
     * @throws \Throwable
     */
    public function makeNew(
        string $s1,
        string $s2,
        string $s3,
        string $cityName,
        int $stateID,
        int $countryID,
        string $postalCode,
        float $lng = 0,
        float $lat = 0):Address {

        $addr = new Address([
            'street_1' => $s1,
            'street_2' => $s2,
            'street_3' => $s3,
            'city_name' => $cityName,
            'state_id' => $stateID,
            'country_id' => $countryID,
            'postal_code' => $postalCode,
            'latitude' => $lat,
            'longitude' => $lng,
        ]);

        // TODO: Eventually put a find similar here

        $addr->saveOrFail();

        return $addr;
    }
}
