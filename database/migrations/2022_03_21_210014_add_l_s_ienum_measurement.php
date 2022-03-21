<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLSIenumMeasurement extends Migration
{
    /**
     * Run the migrations.
     *
     * Add LSI to Metric Enum
     *
     * @return void
     */
    public function up()
    {
        //
        \DB::statement("ALTER TABLE `measurements` CHANGE `metric` `metric` ENUM('ph', 'orp', 'conductivity', 'free chlorine', 'total chlorine', 'alkalinity', 'calcium',
                'temperature', 'pressure', 'flow', 'LSI', 'other') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Other';");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
