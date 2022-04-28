<?php

namespace App\Models;

use App\Exports\MeasurementsAllExport;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $bumblebee_id
 * @property int $calibrator_id
 * @property string $calibration_type
 * @property string $metric
 * @property string $method
 * @property string $default_input_units
 * @property string $default_output_units
 * @property float $slope_m
 * @property float $offset_b
 * @property boolean $effective
 * @property \Illuminate\Support\Carbon $effective_timestamp
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Calibration extends Model
{
    use HasFactory;


    //  these are the fields that are mass fillable
    protected $fillable = [
        'bumblebee_id',// bumblebee model link
        'calibrator_id', // user model link
        'calibration_type',
        'metric',
        'method',
        'default_input_units',
        'default_output_units',
        'slope_m',  // y = mx + b
        'offset_b',   // y = mx + b
        'effective',  // mark as effective by default
        'effective_timestamp',
    ];

    public $unitPerUnit = [
        "uVuV"  => 1,
        "uVmV"  => 0.001,
        "uVV"  => 0.000001,
        "mVuV"  => 1000,
        "mVmV"  => 1,
        "mVV"  => 0.001,
        "VuV"  => 1000000,
        "VmV"  => 1000,
        "VV"  => 1,

        "mAA"  => 0.001,
        "AmA"  => 1000,

        "barpsi" => 0.0686476,
        "baratm" => 1.01325,
        "barPa" => 101325,
        "barbar" => 1,
        "psipsi" => 1,
        "psiatm" => 14.6969,
        "psiPa" => 101325,
        "psibar" => 1.01325,
        "atmpsi" => 0.068046,
        "atmatm" => 1,
        "atmPa" => 0.00000986925,
        "atmbar" => 0.986925,
        "Papsi" => 6894.76,
        "Paatm" => 101325,
        "PaPa" => 1,
        "Pabar" => 100000,

        "cfsgpm" => 450,
        "gpmcfs" => 0.0022,

        "ppmppb" => 1000,
        "ppbppm" => 0.001,

        "uS/cmmS/cm" => 1000,
        "mS/cmuS/cm" => 0.001,
    ];

    // eager load
//    protected $with=['calibrator']';

    /**
     * Eloquent belongs to relationships
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bumblebee(){
        return $this->belongsTo(Bumblebee::class);
    }
    public function calibrator(){
        return $this->belongsTo(User::class);
    }
    /**
     * Measurements that have been calibrated by this
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function calibratedMeasurements(){
        return $this->hasMany(Measurement::class);
//        ,'calibration_id', 'id');
    }



    /**
     * All Measurements that are effected by this calibration
     * NOT an eloquent relationship
     * @return Calibration[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function effectedMeasurements(){
        return Measurement::query()
            ->where('bumblebee_id', $this->bumblebee_id )
                ->where('metric', $this->metric)
                ->where('method', $this->method)
                ->where('measurement_timestamp', ">=", $this->effective_timestamp)
                ->get();
    }

    /**
     * Remove the calibration and uncalibrate effected measurements
     * @return void
     */
    public function removeCalibrationAndUncalibrateEffectedMeasurements(){
        Measurement::query()
            ->where('calibration_id', $this->id)
            ->update(['calibrated_unit' => '',
                'calibrated_value' => 0.0,
                'calibration_value' => 0,
                'calibration_id' => 0]);
        $this->effective = 0;
        $this->save();
    }



    /**
     * Run this Calibration on its Measurements
     * @return int number of measurements calibrated
     */
    public function runCalibration(){
        $numberCalibrated = 0;
        if (count($measurements = $this->calibratedMeasurements)){
            foreach ($measurements as $measurement) {
                if($measurement->calibrate()) $numberCalibrated++;
            }
            return $numberCalibrated;
        }
        // not eloquent
        if (count($measurements = $this->effectedMeasurements())){
            foreach ($measurements as $measurement) {
                $measurement->calibration_id = $this->id;   // must set the calibration id prior
                if($measurement->calibrate()) $numberCalibrated++;
            }
            return $numberCalibrated;
        }
        return $numberCalibrated;
    }

    /**
     * Is the Calibration Complete
     * @return bool calibration is complete
     */
    public function filled():bool {
        return (
            $this->bumblebee_id > 0
            && $this->calibrator_id > 0
            && strlen($this->calibration_type) > 0
            && strlen($this->metric) > 0
            && strlen($this->method) > 0
            && strlen($this->default_output_units) > 0
            && strlen($this->effective_timestamp) > 10
            && is_numeric($this->slope_m)
            && is_numeric($this->offset_b)
            && ($this->effective == 0 || $this->effective ==1)
        );
    }

    /**
     * Conversion Multiplier for Units
     *
     * @param $inputUnit
     * @param $outputUnit
     * @return float will return 0 if no match
     */
    public function unitToUnitMultiplier($inputUnit, $outputUnit){

        $multiplier = $this->unitPerUnit[$inputUnit.$outputUnit];
        if ($multiplier == null) return 0.0;
        return $multiplier;
    }

    /**
     * Solve the linear equation slope and offset
     *
     * @param float $x1
     * @param float $y1
     * @param float $x2
     * @param float $y2
     * @return float[]
     */
    public function solveLinearSlopeAndOffset(float $x1, float $y1, float $x2, float $y2){

        $slope_m = 0;
        $offset_b = 0;

        if (($x2 - $x1) != 0) {

            $offset_b = ($x2 * $y1 - $x1 * $y2) / ($x2 - $x1);

            if ($x2 != 0) {
                $slope_m = ($y2 - $offset_b) / $x2;
            } elseif ($x1 != 0) {
                $slope_m = ($y1 - $offset_b) / $x1;
            }
        }

        return [
            "offset_b" => $offset_b,
            "slope_m" => $slope_m,
        ];
    }

    /**
     * @param Measurement $measurement
     * @return float|int
     */
    public function outputValue(Measurement $measurement){
        switch ($this->calibration_type) {
            case 'linear':
                return $measurement->value * $this->slope_m * $this->offset_b;
            case 'color shift':
                return 0.0;
            case 'color absorption':
                return 0.0;
        }
        return 0.0;
    }

    /**
     * Valid Calibration Types for a given method
     * @param $method
     * @return string[]
     */
    public function calibrationTypesForMethod($method = ''){
        if ($method == '') $method = $this->method;
        return match ($method) {
            'probe' => array('linear'),
            'colorimetric' => array('color absorption'),
            default => array('linear', 'color absorption'),
        };
    }

    public static function calibrationTypeEnums(){
        return array('linear', 'color absorption', 'color shift');
    }

    public static function calibrationMethodEnums(){
        return array('probe', 'colorimetric');
    }

}
