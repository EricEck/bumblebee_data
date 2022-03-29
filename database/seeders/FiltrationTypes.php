<?php

namespace Database\Seeders;

use App\Models\FiltrationType;
use Illuminate\Database\Seeder;

class FiltrationTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->makeNew(1, 'Sand Filter', 'Sand filters use a specially graded sand as the filter media.   Sand replaced 3-8 years.');
        $this->makeNew(2, 'Cartridge Filter', 'Cartridge filters use a paper-type cartridge as the filter media. Clean 1-2 times per year.');
        $this->makeNew(2, 'DE Filter', 'DE filters use diatomaceous earth as a filter media. DE powder needs to be added every time you vacuum and then back-washed afterwards.');
    }

    public function makeNew(int $order, string $name, string $description){

        $ft = new FiltrationType([
            'name' => $name,
            'description' => $description,
            'order' => $order,
        ]);

        $ft->save();

        return $ft;

    }
}
