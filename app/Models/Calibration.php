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
 * @property string $effective_timestamp
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
            'colorimetric' => array('color absorption', 'color shift'),
            default => array('linear', 'color absorption', 'color shift'),
        };
    }
    public static function calibrationTypeEnums(){
        return array('linear', 'color absorption', 'color shift');
    }

    public static function calibrationMethodEnums(){
        return array('probe', 'colorimetric');
    }

}
