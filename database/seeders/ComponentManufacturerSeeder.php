<?php

namespace Database\Seeders;

use App\Models\ComponentManufacturer;
use Illuminate\Database\Seeder;

class ComponentManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $this->makeNew(
            'Elliptic Works, LLC',
        'Smart Pool Devices for healthier pools in the most efficient way.',
        'https://www.ellipticworks.com/',
        'https://www.ellipticworks.com/',
        1);

    }

    private function makeNew(
         $name,
        $description,
        $website_main_url,
        $website_service_url,
        $is_elliptic_works){

        $cm = new ComponentManufacturer([
            'name' => $name,
            'description' => $description,
            'website_main_url' => $website_main_url,
            'website_service_url' => $website_service_url,
            'is_elliptic_works' => $is_elliptic_works,
        ]);

        $cm->save();

        return $cm;
    }
}
