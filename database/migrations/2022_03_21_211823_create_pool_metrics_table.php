<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoolMetricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pool_metrics', function (Blueprint $table) {
            $table->id();

            $table->foreignId('bumblebee_id')->default(0);  // bumblebee model link
            $table->foreignId('measurement_id')->default(0);  // measurement model link
            $table->timestamp('pool_metric_timestamp')->default(null);
            $table->enum('metric', [
                'ph', 'orp', 'conductivity', 'TDS', 'free chlorine', 'total chlorine', 'alkalinity', 'calcium',
                'temperature', 'pressure', 'flow', 'LSI', 'other'])->default('other');
            $table->float('metric_float_value')->default(0.0);
            $table->enum('unit', [
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
                'none'
            ])->default('none');

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
        Schema::dropIfExists('pool_metrics');
    }
}
