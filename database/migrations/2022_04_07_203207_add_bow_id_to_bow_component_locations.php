<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBowIdToBowComponentLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bow_component_locations', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\BodiesOfWater::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bow_component_locations', function (Blueprint $table) {
            $table->dropColumn('bodies_of_water_id');
        });
    }
}
