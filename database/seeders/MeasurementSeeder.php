<?php

namespace Database\Seeders;

use App\Models\Bumblebee;
use App\Models\Measurement;
use Illuminate\Database\Seeder;

class MeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // add a calibration measurement to each type of measurement here

        $bumblebee = Bumblebee::where('serial_number', 'bb_1')->firstOrFail();

        $this->makeCalibrationMeasurements($bumblebee);
        $this->command->info('Calibration Reference Seeder Measurements Added');

        Measurement::factory(10)->create([
            'bumblebee_id' => $bumblebee->id
        ]);
        $this->command->info('Seeder Measurements Added');
    }

    /**
     * Make reference calibration measurements
     * @param Bumblebee $bumblebee
     * @return void
     */
    public function makeCalibrationMeasurements(Bumblebee $bumblebee){
        Measurement::create([
            'bumblebee_id' => $bumblebee->id,
            'measurement_timestamp' => now(),
            'metric_sequence' => '1',
            'metric' => 'ph',
            'method' => 'manual_colorimetric',
            'process' => '{}',
            'value' => 7.4,
            'unit' => 'none',
            'details' => '',
            'calibration_value' => true
        ]);
        Measurement::create([
            'bumblebee_id' => $bumblebee->id,
            'measurement_timestamp' => now(),
            'metric_sequence' => '1',
            'metric' => 'orp',
            'method' => 'manual_colorimetric',
            'process' => '{}',
            'value' => 450,
            'unit' => 'mV',
            'details' => '',
            'calibration_value' => true
        ]);
        Measurement::create([
            'bumblebee_id' => $bumblebee->id,
            'measurement_timestamp' => now(),
            'metric_sequence' => '1',
            'metric' => 'conductivity',
            'method' => 'manual_colorimetric',
            'process' => '{}',
            'value' => 2750,
            'unit' => 'uS/cm',
            'details' => '',
            'calibration_value' => true
        ]);
        Measurement::create([
            'bumblebee_id' => $bumblebee->id,
            'measurement_timestamp' => now(),
            'metric_sequence' => '1',
            'metric' => 'conductivity',
            'method' => 'manual_colorimetric',
            'process' => '{}',
            'value' => 2750,
            'unit' => 'uS/cm',
            'details' => '',
            'calibration_value' => true
        ]);
        Measurement::create([
            'bumblebee_id' => $bumblebee->id,
            'measurement_timestamp' => now(),
            'metric_sequence' => '1',
            'metric' => 'free chlorine',
            'method' => 'manual_colorimetric',
            'process' => '{}',
            'value' => 2.2,
            'unit' => 'ppm',
            'details' => '',
            'calibration_value' => true
        ]);
        Measurement::create([
            'bumblebee_id' => $bumblebee->id,
            'measurement_timestamp' => now(),
            'metric_sequence' => '1',
            'metric' => 'total chlorine',
            'method' => 'manual_colorimetric',
            'process' => '{}',
            'value' => 2.8,
            'unit' => 'ppm',
            'details' => '',
            'calibration_value' => true
        ]);
        Measurement::create([
            'bumblebee_id' => $bumblebee->id,
            'measurement_timestamp' => now(),
            'metric_sequence' => '1',
            'metric' => 'alkalinity',
            'method' => 'manual_colorimetric',
            'process' => '{}',
            'value' => 90,
            'unit' => 'ppm',
            'details' => '',
            'calibration_value' => true
        ]);
        Measurement::create([
            'bumblebee_id' => $bumblebee->id,
            'measurement_timestamp' => now(),
            'metric_sequence' => '1',
            'metric' => 'calcium',
            'method' => 'manual_colorimetric',
            'process' => '{}',
            'value' => 205,
            'unit' => 'ppm',
            'details' => '',
            'calibration_value' => true
        ]);
        Measurement::create([
            'bumblebee_id' => $bumblebee->id,
            'measurement_timestamp' => now(),
            'metric_sequence' => '1',
            'metric' => 'temperature',
            'method' => 'probe',
            'process' => '{}',
            'value' => 73,
            'unit' => 'F',
            'details' => '',
            'calibration_value' => true
        ]);
        Measurement::create([
            'bumblebee_id' => $bumblebee->id,
            'measurement_timestamp' => now(),
            'metric_sequence' => '1',
            'metric' => 'pressure',
            'method' => 'probe',
            'process' => '{}',
            'value' => 16,
            'unit' => 'psi',
            'details' => '',
            'calibration_value' => true
        ]);
        Measurement::create([
            'bumblebee_id' => $bumblebee->id,
            'measurement_timestamp' => now(),
            'metric_sequence' => '1',
            'metric' => 'flow',
            'method' => 'probe',
            'process' => '{}',
            'value' => 12,
            'unit' => 'gpm',
            'details' => '',
            'calibration_value' => true
        ]);
    }
}
