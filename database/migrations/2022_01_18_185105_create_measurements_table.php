<?php

use App\Models\Measurement;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('measurements', function (Blueprint $table) {
            $table->id()->autoIncrement()->index()->unique();
            $table->foreignId('bumblebee_id');  // bumblebee model link
            $table->timestamp('measurement_timestamp')->default(null);
            $table->integer('metric_sequence');

            $table->enum('metric', [
                'ph', 'orp', 'conductivity', 'free chlorine', 'total chlorine', 'alkalinity', 'calcium',
                'temperature', 'pressure', 'flow', 'other'])->default('other');

            $table->enum( 'method',[
                'probe', 'colorimetric', 'other',
                'manual_titration', 'manual_colorimetric', 'manual_teststrip','manual_probe'])->default('other');

            $table->string('process', 2048)->nullable();    // added 01-19-22 by eae

            $table->string('value', 1024)->nullable();

            $table->enum('unit', [
                'uV', 'mV', 'V', 'uA', 'mA', 'A',
                'count',
                'bar', 'psi', 'atm', 'Pa',
                'F', 'C',
                'gpm', 'cfs',
                'ppm', 'ppb',
                'uS/cm', 'mS/cm',
                'none'
                ])->nullable();

            $table->string('details', 1024)->nullable();
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
        Schema::dropIfExists('measurements');
    }
}
