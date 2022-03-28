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
            $this->makeCountry('United States of America', 'USA', 'US', 37.0902,-95.7129);
        }
    }


    /**
     * @param string $name
     * @param string $shortName
     * @param string $countryCode
     * @param float $lat
     * @param float $lng
     * @return Country
     */
    private function makeCountry(string $name, string $shortName, string $countryCode, float $lat, float $lng): Country
    {
        $c = new Country([
            'name' => $name,
            'short_name' => $shortName,
            'country_code' => $countryCode,
            'latitude' => $lat,
            'longitude' => $lng,
        ]);
        $c->save();
        return $c;
    }
}
