<?php

namespace Database\Seeders;

use App\Models\EllipticManufacturer;
use Illuminate\Database\Seeder;

class EllipticManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->makeNew(
            'Made To Deliver, LLC',
            'Engineering and development company specializing in early product development for electrical, mechanical and embedded software',
        4,
            'Tom Sowers',
            '1-717-945-8140',
            'tomsowers2@gmail.com',
            ''
        );

        $this->command->line('Elliptic Manufacturer Seeder Complete');
    }

    private function makeNew(string $name,
                             string $description,
                             int $address_id,
                             string $contact,
                             string $phone_work,
                             string $email_work,
                             string $website_main_url){

        $em = new EllipticManufacturer([
            'name' => $name,
            'description' => $description,
            'address_id' => $address_id,
            'contact' => $contact,
            'phone_work' => $phone_work,
            'email_work' => $email_work,
            'website_main_url' => $website_main_url,
        ]);

        try {
            $em->saveOrFail();
            $this->command->line('Elliptic Model Seeder, made: '.$name);

        } catch (\Exception $e){
            $this->command->error('ERROR: Elliptic Model Seeder, '.$e->getMessage());
        }

        return $em;
    }
}
