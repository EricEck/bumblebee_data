<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Country::where('name', 'USA')->exists()) {
            $this->makeCountry('United States of America', 'USA', 37.0902,-95.7129);
        }
    }

    /**
     * @param string $name
     * @param string $shortName
     * @param float $lat
     * @param float $lng
     * @return Country
     */
    private function makeCountry(string $name, string $shortName, float $lat, float $lng): Country
    {
        $c = new Country([
            'name' => $name,
            'short_name' => $shortName,
            'latitude' => $lat,
            'longitude' => $lng,
        ]);
        $c->save();
        return $c;
    }
}
