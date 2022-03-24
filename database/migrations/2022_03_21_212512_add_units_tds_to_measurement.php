<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitsTdsToMeasurement extends Migration
{
    /**
     * Run the migrations.
     *
     * new units and new TDS Metric
     *
     * @return void
     */
    public function up()
    {
        Schema::table('measurement', function (Blueprint $table) {
            //
            \DB::statement("ALTER TABLE `measurements` CHANGE `metric` `metric` ENUM('ph', 'orp', 'conductivity', 'TDS', 'free chlorine', 'total chlorine', 'alkalinity', 'calcium',
                'temperature', 'pressure', 'flow', 'LSI', 'other') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'other';");

            \DB::statement("ALTER TABLE `measurements` CHANGE `unit` `unit` ENUM(
                'uV', 'mV', 'V',
                'uA', 'mA', 'A',
                'count',
                'bar', 'psi', 'atm', 'Pa',
                'F', 'C',
                'gpm', 'cfs',
                'ppm', 'ppb', 'mg/L',
                'mm', 'cm', 'm', 'in', 'ft',
                'mL', 'L', 'oz', 'pt', 'qt', 'gal',
                'lb', 'g', 'kg',
                'uS/cm', 'mS/cm',
                'none') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none';");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
