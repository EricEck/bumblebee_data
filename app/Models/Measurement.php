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
    public function valueJSON(){
        return str_replace("'", '"', $this->value);
    }

    /**
     * Return the value of the measurement decoding the JSON send based upon the method
     */
    public function valueDecodeTable(){

        if ($this->manualMethod()){
//            debugbar()->info('manualMethod: '.$this->value);
            return floatval(json_decode($this->valueJSON())->value);
        }
        if ($this->probeMethod()){
            return floatval(json_decode($this->valueJSON())->value->voltage);
        }
        if($this->colorimetricMethod()){
            $v = json_decode($this->valueJSON())->value;
            return  "violet =  ".$v->violet.PHP_EOL.
                     ", indigo =  ".$v->indigo."\n".
                     ", blue =  ".$v->blue."\n".
                     ", cyan =  ".$v->cyan."\n".
                ", green = ".$v->green."\n".
                ", yellow = ".$v->yellow.PHP_EOL.
                ", orange = ".$v->orange.PHP_EOL.
                ", red = ".$v->red.PHP_EOL.
                ", clear = ".$v->clear.PHP_EOL.
                ", nearIR = ".$v->nearIR.PHP_EOL;

//                green" =  ".$v->green."\n";
//                     "yellow =  ".$v->yellow."\n".
//                     "orange =  ".$v->violet."\n".
//                     "red" =  ".$v->red."\n\n".
//                     "clear =  ".$v->clear."\n".
//                     "nearIR =  ".$v->nearIR."\n";
//            return json_decode($this->valueJSON())->value;
        }

        return $this->valueJSON();
    }


    /**
     * Search for specific measurements(s) across all visible fields
     *
     * @param string $search
     * @return Measurement|\Illuminate\Database\Eloquent\Builder
     */
    public static function searchView(string $search,
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



//        debugbar()->info('metric '.$metric_search_operator.' '.$metric);
//        debugbar()->info('method '.$method_search_operator.' '.$method);
//        debugbar()->info('type '.$type_search_operator.' '.$type);
//        debugbar()->info('start '.$start_datetime);
//        debugbar()->info('end '.$end_datetime);

        debugbar()->info('order by: '.$sort_by." ".$orderAscending );

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
