<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActualAndCalToMeasurements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('measurements', function (Blueprint $table) {
            //
            $table->float('calibrated_value')->default(0.0);
            $table->string('calibrated_unit')->default("");
            $table->foreignId('calibration_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('measurements', function (Blueprint $table) {
            //
            $table->dropColumn('calibrated_value');
            $table->dropColumn('calibrated_unit');
            $table->dropColumn('calibration_id');
        });
    }
}
