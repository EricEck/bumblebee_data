<?php

namespace Database\Seeders;

use App\Models\ConstructionType;
use Illuminate\Database\Seeder;

class ConstructionTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->makeNew(1, 'Gunite', 'Concrete and sand mixture with a rebar framework');
        $this->makeNew(2, 'Fiberglass', 'Molded and installed in-ground');
        $this->makeNew(3, 'Vinyl', 'Vinyl or other synthetic lined pool');
    }

    public function makeNew(int $order, string $name, string $description){
        $ct = new ConstructionType([
            'name' => $name,
            'description' => $description,
            'order' => $order,
        ]);

        $ct->save();

        return $ct;
    }
}
