<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\State;
use Illuminate\Database\Seeder;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Nullable;

class StateSeeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usaID = Country::where('short_name','USA')->first()->id;

        try {
            $this->makeState('Alaska', 'AK', $usaID, 63.588753, -154.493062);
            $this->makeState('Alabama', 'AL', $usaID, 32.318231, -86.902298);
            $this->makeState('Arkansas', 'AR', $usaID, 35.20105, -91.831833);
            $this->makeState('Arizona', 'AZ', $usaID, 34.048928, -111.093731);
            $this->makeState('California', 'CA', $usaID, 36.778261, -119.417932);
            $this->makeState('Colorado', 'CO', $usaID, 39.550051, -105.782067);
            $this->makeState('Connecticut', 'CT', $usaID, 41.603221, -73.087749);
            $this->makeState('District of Columbia', 'DC', $usaID, 38.905985, -77.033418);
            $this->makeState('Delaware', 'DE', $usaID, 38.910832, -75.52767);
            $this->makeState('Florida', 'FL', $usaID, 27.664827, -81.515754);
            $this->makeState('Georgia', 'GA', $usaID, 32.157435, -82.907123);
            $this->makeState('Hawaii', 'HI', $usaID, 19.898682, -155.665857);
            $this->makeState('Iowa', 'IA', $usaID, 41.878003, -93.097702);
            $this->makeState('Idaho', 'ID', $usaID, 44.068202, -114.742041);
            $this->makeState('Illinois', 'IL', $usaID, 40.633125, -89.398528);
            $this->makeState('Indiana', 'IN', $usaID, 40.551217, -85.602364);
            $this->makeState('Kansas', 'KS', $usaID, 39.011902, -98.484246);
            $this->makeState('Kentucky', 'KY', $usaID, 37.839333, -84.270018);
            $this->makeState('Louisiana', 'LA', $usaID, 31.244823, -92.145024);
            $this->makeState('Massachusetts', 'MA', $usaID, 42.407211, -71.382437);
            $this->makeState('Maryland', 'MD', $usaID, 39.045755, -76.641271);
            $this->makeState('Maine', 'ME', $usaID, 45.253783, -69.445469);
            $this->makeState('Michigan', 'MI', $usaID, 44.314844, -85.602364);
            $this->makeState('Minnesota', 'MN', $usaID, 46.729553, -94.6859);
            $this->makeState('Missouri', 'MO', $usaID, 37.964253, -91.831833);
            $this->makeState('Mississippi', 'MS', $usaID, 32.354668, -89.398528);
            $this->makeState('Montana', 'MT', $usaID, 46.879682, -110.362566);
            $this->makeState('North Carolina', 'NC', $usaID, 35.759573, -79.0193);
            $this->makeState('North Dakota', 'ND', $usaID, 47.551493, -101.002012);
            $this->makeState('Nebraska', 'NE', $usaID, 41.492537, -99.901813);
            $this->makeState('New Hampshire', 'NH', $usaID, 43.193852, -71.572395);
            $this->makeState('New Jersey', 'NJ', $usaID, 40.058324, -74.405661);
            $this->makeState('New Mexico', 'NM', $usaID, 34.97273, -105.032363);
            $this->makeState('Nevada', 'NV', $usaID, 38.80261, -116.419389);
            $this->makeState('New York', 'NY', $usaID, 43.299428, -74.217933);
            $this->makeState('Ohio', 'OH', $usaID, 40.417287, -82.907123);
            $this->makeState('Oklahoma', 'OK', $usaID, 35.007752, -97.092877);
            $this->makeState('Oregon', 'OR', $usaID, 43.804133, -120.554201);
            $this->makeState('Pennsylvania', 'PA', $usaID, 41.203322, -77.194525);
            $this->makeState('Puerto Rico', 'PR', $usaID, 18.220833, -66.590149);
            $this->makeState('Rhode Island', 'RI', $usaID, 41.580095, -71.477429);
            $this->makeState('South Carolina', 'SC', $usaID, 33.836081, -81.163725);
            $this->makeState('South Dakota', 'SD', $usaID, 43.969515, -99.901813);
            $this->makeState('Tennessee', 'TN', $usaID, 35.517491, -86.580447);
            $this->makeState('Texas', 'TX', $usaID, 31.968599, -99.901813);
            $this->makeState('Utah', 'UT', $usaID, 39.32098, -111.093731);
            $this->makeState('Virginia', 'VA', $usaID, 37.431573, -78.656894);
            $this->makeState('Vermont', 'VT', $usaID, 44.558803, -72.577841);
            $this->makeState('Washington', 'WA', $usaID, 47.751074, -120.740139);
            $this->makeState('Wisconsin', 'WI', $usaID, 43.78444, -88.787868);
            $this->makeState('West Virginia', 'WV', $usaID, 38.597626, -80.454903);
            $this->makeState('Wyoming', 'WY', $usaID, 43.075968, -107.290284);
        } catch (\Exception $e){
            $this->command->error("Error Running the StateSeeder: ".$e->getMessage());
        }
    }


    /**
     * @param string $name
     * @param string $shortName
     * @param Integer $countryID
     * @param float $lat
     * @param float $lng
     * @return State
     * @throws \Throwable
     */
    private function makeState(string $name, string $shortName, int $countryID, float $lat, float $lng): State
    {
        $s = new State([
            'name' => $name,
            'short_name' => $shortName,
            'country_id' => $countryID,
            'latitude' => $lat,
            'longitude' => $lng,
        ]);
        $s->saveOrFail();
        return $s;
    }
}
