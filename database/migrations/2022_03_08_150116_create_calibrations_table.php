<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalibrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calibrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bumblebee_id'); // bumblebee model link
            $table->foreignId('calibrator_id'); // user model link
            $table->string('calibration_type', 64);
            $table->string('metric');
            $table->string('method');
            $table->string('default_input_units',64)->default('');
            $table->string('default_output_units', 64)->default('');
            $table->float('slope_m')->default(0);   // y = mx + b
            $table->float('offset_b')->default(0);   // y = mx + b
            $table->boolean('effective')->default(1);   // mark as effective by default
            $table->timestamp('effective_timestamp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calibrations');
    }
}
