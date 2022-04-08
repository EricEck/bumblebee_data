<?php

namespace Database\Seeders;

use App\Models\EllipticModel;
use Illuminate\Database\Seeder;

class EllipticModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->makeNew('EW Bumblebee Mark I',
        'The first development model of the Elliptic Works\' Bumblebee water measurement system',
        1,
        1);
        info('Elliptic Model Seeder Complete');
    }

    private function makeNew(string $name, string $description, bool $is_bumblebee, bool $is_active){
        $em = new EllipticModel([
            'name' => $name,
            'description' => $description,
            'is_bumblebee' => $is_bumblebee,
            'is_active' => $is_active,
        ]);

        try {
            $em->saveOrFail();
            info('Elliptic Model Seeder, made: '.$name);

        } catch (\Exception $e){
            info('ERROR: Elliptic Model Seeder, '.$e->getMessage());
        }

        return $em;
    }
}
