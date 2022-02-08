<?php

namespace Database\Factories;

use App\Models\Bumblebee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class BumblebeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $mfg_date = $this->faker->dateTimeBetween("2022-01-01 00:00:01", now());
        $assign_date = $this->faker->dateTimeBetween($mfg_date, now());
        $serial_number = 'bb_'.strval($this->faker->numberBetween(1,10));

        $bumblebee = [
            'serial_number' => $serial_number,
            'manufactured_date' => $mfg_date,
            'current_version' => '0.0.1',
            'manufacturer_id' => 1,
            'owner_id' => 1,
            'install_id' => 1,
            'assigned_to_owner_on' => $assign_date,
            'removed_from_service' => false,
            'api_password' => bcrypt('elliptic'),  // Hash::make('elliptic')
            'remember_token' =>  '0de3cd6c-611c-4898-a149-a9288fe677c5' // was Str::uuid()
        ];

//        // make linked measurements by overriding the factory setting
//        \App\Models\Measurement::factory(10)->create([
//            'bumblebee_id' => $serial_number
//        ]);

        return $bumblebee;
    }
}
