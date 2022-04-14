<?php

namespace Database\Seeders;

use App\Models\BowLocationType;
use Illuminate\Database\Seeder;

class BowLocationTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->makeNew(1,'Swimming Pool', 'Designed primarily for recreational swimming');
        $this->makeNew(2,'Spa/Hot Tub', 'Designed primarily for soaking');
        $this->makeNew(3, 'Lap Pool', 'Designed primarily for exercise with pressure jets');
        $this->makeNew(4, 'Water Fall', 'Designed primarily for aesthetics');
        $this->makeNew(5, 'Water Show', 'Designed primarily for aesthetics');
    }

    /**
     * Make a new BOW Location Type
     * @param string $name
     * @param string $description
     * @return BowLocationType
     */
    public function makeNew(int $order, string $name, string $description){

        $blt = new BowLocationType([
            'name' => $name,
            'description' => $description,
            'order' => $order,
        ]);

        $blt->save();

        return $blt;

    }
}
