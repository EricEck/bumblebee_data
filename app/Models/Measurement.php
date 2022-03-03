<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Psy\Util\Json;
use function Livewire\str;

/**
 * App\Models\Measurement
 *
 * @property int $id
 * @property string $bumblebee_id
 * @property string $measurement_timestamp
 * @property int $metric_sequence
 * @property string $metric
 * @property string $method
 * @property string|null $value
 * @property string|null $unit
 * @property string|null $details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereBumblebeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereMeasurementTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereMetric($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereMetricSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereValue($value)
 * @mixin \Eloquent
 * @property string|null $process
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereProcess($value)
 * @method static \Database\Factories\MeasurementFactory factory(...$parameters)
 * @property int $calibration_value
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereCalibrationValue($value)
 */
class Measurement extends Model
{
    use HasFactory;

    // everything except what is here is fillable
//    protected $guarded = ['id'];
    //  these are the fields that are mass fillable
    protected $fillable = [
        'bumblebee_id',
        'measurement_timestamp',
        'metric_sequence',
        'metric',
        'method',
        'process',
        'value',
        'unit',
        'details',
        'calibration_value'
    ];


    /**
     * Find the Newest Measurement for a Bumblebee
     * @param $bumblebeeID
     * @return Measurement|\Illuminate\Database\Eloquent\Builder|Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function newestMeasurement($bumblebeeID){
        return Measurement::where('id',$bumblebeeID)
            ->orderBy('created_at', 'desc')
            ->first();
    }


    /**
     * Utility method to test Process is JSON
     *
     * will 'fix' this instance (not save) if saves as single quoted python dictionary
     *
     * @return bool
     */
    public function processIsJSON() {
        json_decode($this->process);
        if (json_last_error() == JSON_ERROR_NONE) return true;

        // python has a wierd way of uploading JSON
        $temp = json_decode(str_replace("'", '"', $this->process));
        if (json_last_error() == JSON_ERROR_NONE) {
            $this->process = $temp;
            return true;
        }
        return false;
    }

    /**
     * All Possible metrics for measurements
     *
     * @return array
     */
    public static function metricEnums(){
        return array(
            'ph','orp', 'conductivity', 'free chlorine', 'total chlorine', 'alkalinity', 'calcium',
                'temperature', 'pressure', 'flow', 'other');
    }

    /**
     * All Possible methods for measurements
     *
     * @return array
     */
    public static function methodEnums(){
        return array(
            'probe', 'colorimetric',
            'manual_titration', 'manual_colorimetric', 'manual_teststrip', 'other');
    }

    /**
     * All Possible methods for measurements (manual only)
     *
     * @return array
     */
    public static function methodManualEnums(){
        return array('manual_titration', 'manual_colorimetric', 'manual_teststrip');
    }


    /**
     * Check the type of Method is Colorimetric
     *
     * @return bool if a Colorimetric Method
     */
    public function colorimetricMethod(){
        switch ($this->method){
            case 'colorimetric':
                return true;
            default:
                return false;
        }
    }

    /**
     * Check the type of Method is Manual
     *
     * @param $method
     * @return bool if a manual Method
     */
    public function isManualMethod($method){
        switch ($method){
            case 'manual_titration':
            case 'manual_colorimetric':
            case 'manual_teststrip':
                return true;
            default:
                return false;
        }
    }

    /**
     * Check the type of Method is Manual
     *
     * @return bool if a manual Method
     */
    public function manualMethod(){
        switch ($this->method){
            case 'manual_titration':
            case 'manual_colorimetric':
            case 'manual_teststrip':
                return true;
            default:
                return false;
        }
    }

    /**
     * Check the type of Method is Probe
     *
     * @return bool if a voltage Method
     */
    public function probeMethod(){
        switch ($this->method){
            case 'probe':
                return true;
            default:
                return false;
        }
    }



    /**
     * All Possible units for measurements
     *
     * @return array
     */
    public static function unitEnums(){
        return array(
            'uV', 'mV', 'V', 'uA', 'mA', 'A',
            'count',
            'bar', 'psi', 'atm', 'Pa',
            'F', 'C',
            'gpm', 'cfs',
            'ppm', 'ppb',
            'uS/cm', 'mS/cm',
            'none');
    }

    /**
     * Return the corrected JSON format, pythod JSON used f'd up single quotes
     * @return string
     */
    public function forceDoubleQuotedJSON(){
        return str_replace("'", '"', $this->value);
    }



    /**
     * Return the value of the measurement decoding the JSON send based upon the method
     */
    public function valueDecodeNumber(){

        if ($this->manualMethod()){
//            debugbar()->info('manualMethod: '.$this->value);
            return floatval(json_decode($this->forceDoubleQuotedJSON())->value);
        }
        if ($this->probeMethod()){
            return floatval(json_decode($this->forceDoubleQuotedJSON())->value->voltage);
        }
        if($this->colorimetricMethod()){
            // for this return the color JSON
            $v = json_decode($this->forceDoubleQuotedJSON())->value;
            return  $v;
        }

        return $this->forceDoubleQuotedJSON();
    }

    /**
     * Return Just the Colorimetry Data Scaled or Not zScalled
     * @param int $scaled
     * @return null|JSON
     */
    public function valueDecodeColor($scaled = 0){

        if($this->colorimetricMethod()){
            $c = json_decode($this->forceDoubleQuotedJSON())->value;
            if ($scaled > 0){
                $reference = $c->clear;
                if ($scaled == 2) $reference = $this->maximumColorValue();
                $c->violet = round($c->violet / $reference, 3);
                $c->indigo = round($c->indigo / $reference, 3);
                $c->blue = round($c->blue / $reference, 3);
                $c->cyan = round($c->cyan / $reference, 3);
                $c->green = round($c->green / $reference, 3);
                $c->yellow = round($c->yellow / $reference, 3);
                $c->orange = round($c->orange / $reference, 3);
                $c->red = round($c->red / $reference, 3);
                $c->nearIR = round($c->nearIR / $reference, 3);
            }
            return $c;
        }
        return null;
    }

    public function maximumColorValue()
    {
        if ($this->colorimetricMethod()){
            $c = json_decode($this->forceDoubleQuotedJSON())->value;

            $max = $c->violet;
            if ($c->indigo > $max) $max = $c->indigo;
            elseif ($c->blue > $max) $max = $c->blue;
            elseif ($c->cyan > $max)  $max = $c->cyan;
            elseif ($c->green > $max)  $max = $c->green;
            elseif ($c->yellow > $max)  $max = $c->yellow;
            elseif ($c->orange > $max)  $max = $c->orange;
            elseif ($c->red > $max)  $max = $c->red;
            return $max;
        }
        return null;
    }



    /**
     * Search for specific measurements(s) across all visible fields
     *
     * @param string $search
     * @return Measurement|\Illuminate\Database\Eloquent\Builder
     */
    public static function searchView(
                                      int $bumblebeeID,
                                      string $metric,
                                      string $method,
                                      string $type,
                                      string $start_datetime,
                                      string $end_datetime,
                                      string $sort_by,
                                      string $orderAscending

//                                      bool $measurementMetric,
//                                      bool $calibrationMetric
    ){

        $bumblebee_search_operator = "=";
        if($bumblebeeID == 0) $bumblebee_search_operator = "!=";

        $metric_search_operator = "=";
        if($metric == "all") $metric_search_operator = "!=";
        $method_search_operator = "=";

        $method_search_operator = "=";
        if($method == "all") $method_search_operator = "!=";
        if($method == "auto") {
            $method_search_operator = "not like";
            $method = "%manual%";
        }
        if($method == "man") {
            $method_search_operator = "like";
            $method = "%manual%";
        }

        $type_search_operator = "=";
        if($type == "2") $type_search_operator = "<";

        switch($sort_by){
            case 'time':
                $sort_by = "measurement_timestamp";
                break;
            case 'id':
                $sort_by = "id";
                break;
            default:
            case 'seq':
                $sort_by = "metric_sequence";
        }

        return static::query()
            ->where('bumblebee_id', $bumblebee_search_operator, $bumblebeeID)
            ->where('metric', $metric_search_operator, $metric)
            ->where('method', $method_search_operator, $method)
            ->where('calibration_value', $type_search_operator, $type)
            ->where('measurement_timestamp', '>', $start_datetime)
            ->where('measurement_timestamp', '<', $end_datetime)
            ->orderBy($sort_by, $orderAscending );
    }

    /**
     * Eloquent belongs to relationship Bumblebee Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bumblebee(){
        return $this->belongsTo(Bumblebee::class);
    }

}
