<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MeasurementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $metricEnum = [
            'ph', 'orp', 'conductivity', 'free chlorine', 'total chlorine', 'alkalinity', 'calcium',
            'temperature', 'pressure', 'flow', 'other'];
        $methodEnum = [
            'probe', 'colorimetric', 'other'];
        $unitEnum = [
            'uV', 'mV', 'V', 'uA', 'mA', 'A',
            'count',
            'bar', 'psi', 'atm', 'Pa',
            'F', 'C',
            'gpm', 'cfs',
            'ppm', 'ppb',
            'uS/cm','mS/cm',
            'none'
        ];


        // TODO: check factory change for JSON formatting

        return [
            'bumblebee_id' => $this->faker->numberBetween(1,10),
            'measurement_timestamp' => $this->faker->dateTimeBetween("2022-01-01 00:00:01", now()),
            'metric_sequence' => $this->faker->buildingNumber(),
            'metric' => $metricEnum[rand(0,count($metricEnum) - 1)],
            'method' => $methodEnum[rand(0,count($methodEnum) - 1)],
            'process'=> "{}",
            'value' => '{"value:":'.strval($this->faker->randomFloat(5,0,100)).'}',
            'unit' => $unitEnum[rand(0,count($unitEnum) - 1)],
            'details' => $this->faker->sentence(),
            'calibration_value' => false

        ];
    }
}
