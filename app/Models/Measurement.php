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
 * @property int $bumblebee_id
 * @property \Illuminate\Support\Carbon|null $measurement_timestamp
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
        'calibration_value',
        'calibrated_value',
        'calibrated_unit',
        'calibration_id',
        'bodies_of_water_id',
    ];

    protected $attributes = [
        'bumblebee_id' => 0,
        'measurement_timestamp' => null,
        'metric_sequence' => 0,
        'metric' => '',
        'method' => '',
        'process' => '',
        'value' => '',
        'unit' => '',
        'details' => '',
        'bodies_of_water_id' => 0,
    ];

    // eager load the bumblebee
    protected $with = ['bumblebee'];

    // Eloquent Relationships
    public function bumblebee(){
        return $this->belongsTo(Bumblebee::class);
    }
    public function calibration(){
        return $this->belongsTo(Calibration::class);
    }
    public function bodyOfWater(){
        return $this->hasOne(BodiesOfWater::class, 'id', 'bodies_of_water_id');
    }



    // STATIC METHODS

    /**
     * All Possible metrics for measurements
     *
     * @return array
     */
    public static function metricEnums(){
        return array(
            'ph','orp', 'conductivity', 'free chlorine', 'total chlorine', 'alkalinity', 'calcium',
            'temperature', 'pressure', 'flow', 'LSI', 'other');
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
     * All Possible methods for measurements
     *
     * @return array
     */
    public static function methodEnums(){
        return array(
            'probe', 'colorimetric',
            'manual_titration', 'manual_colorimetric', 'manual_teststrip', 'manual_probe', 'other');
    }
    /**
     * All Possible methods for measurements (manual only)
     *
     * @return array
     */
    public static function methodManualEnums(){
        return array('manual_titration', 'manual_colorimetric', 'manual_teststrip', 'manual_probe');
    }
    public static function displayMetricMethodUnits(){
        return array(
            ['metric' => 'ph', 'method' => 'probe', 'unit' => ''],
            ['metric' => 'orp', 'method' => 'probe', 'unit' => 'mV'],
            ['metric' => 'ph', 'method' => 'colorimetric', 'unit' => ''],
            ['metric' => 'conductivity', 'method' => 'probe', 'unit' => 'uS/cm'],
            ['metric' => 'temperature', 'method' => 'probe', 'unit' => 'F'],
            ['metric' => 'pressure', 'method' => 'probe', 'unit' => 'psi'],
            ['metric' => 'free chlorine', 'method' => 'colorimetric', 'unit' => 'ppm'],
            ['metric' => 'total chlorine', 'method' => 'colorimetric', 'unit' => 'ppm'],
            ['metric' => 'alkalinity', 'method' => 'colorimetric', 'unit' => 'ppm'],
            ['metric' => 'calcium', 'method' => 'colorimetric', 'unit' => 'ppm'],
            ['metric' => 'LSI', 'method' => 'calculation', 'calculation' => 'lsi', 'unit' => ''],
        );
    }
    public static function allBetweenTimesforBowId(int $bow_id, string $endTime, string $startTime){
        return Measurement::query()
            ->where('bodies_of_water_id', $bow_id)
            ->where('measurement_timestamp', '<=', $endTime)
            ->where('measurement_timestamp', '>=', $startTime)
            ->orderBy('measurement_timestamp', 'desc')
            ->get();
    }
    /**
     * Find all non-calibration bow/metric/method between two times
     * @param int $bow_id
     * @param string $metric
     * @param string $method
     * @param string $endTime
     * @param string $startTime
     * @return Measurement[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public static function allNonCalibrationBetweenTimesforMetricMethodBowId(int $bow_id, string $metric, string $method, string $endTime, string $startTime){
        return Measurement::query()
            ->where('calibration_value', 0)
            ->where('bodies_of_water_id', $bow_id)
            ->where('metric', $metric)
            ->where('method', $method)
            ->where('measurement_timestamp', '<=', $endTime)
            ->where('measurement_timestamp', '>=', $startTime)
            ->orderBy('measurement_timestamp', 'desc')
            ->get();
    }
    public static function latestMeasurementforBowID(int $bow_id){
        return Measurement::query()
            ->where('bodies_of_water_id', $bow_id)
            ->orderBy('measurement_timestamp', 'desc')
            ->first();
    }
    /**
     * Latest non-calibration measurement for bow between two times
     * @param int $bow_id
     * @return Measurement|\Illuminate\Database\Eloquent\Builder|Model|\Illuminate\Database\Query\Builder|object|null
     */
    public static function latestNonCalibrationMeasurementforBowID(int $bow_id){
        return Measurement::query()
            ->where('bodies_of_water_id', $bow_id)
            ->where('calibration_value', 0)
            ->orderBy('measurement_timestamp', 'desc')
            ->first();
    }



    // METHODS

    public function filled(){
        return (
            $this->bumblebee_id > 0
            && strlen($this->metric) > 0
            && strlen($this->method) > 0
            && strlen($this->unit) > 0
            && strlen($this->value) > 0
        );
    }

    /**
     * Calibrate THIS Measurement and Save
     * @return bool true if calibrated successful and saved (even if calibration is removed)
     * @throws \Throwable
     */
    public function calibrate():bool {

        if ($this->calibration_id) {
            if ($this->calibration->effective) {
                if ($this->doTheCalibrationMath())
                    return $this->updateOrFail(); // catch any error on the calling function to this!
                return false;
            }
        } elseif ($calibration_id = $this->getEffectiveCalibration()->id) {
            $this->calibration_id = $calibration_id;
            if ($this->doTheCalibrationMath())
                return $this->updateOrFail(); // catch any error on the calling function to this!
            return false;
        }

        $this->clearTheCalibration();
        return $this->updateOrFail();
    }

    /**
     * Perform the Calibration Mathematics
     * @return bool success
     */
    private function doTheCalibrationMath(){
        switch ($this->calibration->calibration_type){
            case 'linear':
                $this->calibrated_value = $this->calibration->slope_m * $this->valueDecodeNumber() + $this->calibration->offset_b;
                break;
            case 'color absorption':
                // made sure only positive numbers
                $this->calibrated_value = max($this->calibration->slope_m * $this->metricColorimetryValue() + $this->calibration->offset_b, 0);
                break;
            default:
                return false;
        }
        $this->calibrated_unit = $this->calibration->default_output_units;
        return true;
    }

    /**
     * Clear the Calibration Value and Link
     * @return void
     */
    private function clearTheCalibration(){
        $this->calibrated_unit = "";
        $this->calibrated_value = 0.0;
        $this->calibration_value = 0;
        $this->calibration_id = 0;
    }

    /**
     * Find the Effective Calibration for this Measurement
     *
     * @return Calibration|\Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public function getEffectiveCalibration(){
        return Calibration::where('bumblebee_id', $this->bumblebee_id)
            ->where('metric', $this->metric)
            ->where('method', $this->method)
            ->where('effective', 1)
            ->where('effective_timestamp', '<=', $this->measurement_timestamp)
            ->orderBy('effective_timestamp', 'desc')
            ->first();
    }

    /**
     * Find the relevant calibration
     * @return Calibration|\Illuminate\Database\Eloquent\Builder|Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function calibration_find(){
        return Calibration::query()
            ->where('bumblebee_id', $this->bumblebee_id)
            ->where('metric', $this->metric)
            ->where('method', $this->method)
            ->where('effective', 1)
            ->where('effective_timestamp', '<=', $this->measurement_timestamp)
            ->orderBy('effective_timestamp', 'desc')
            ->first();
    }

    /**
     * Calculation for Colorimetric Value UNCALIBRATED
     *
     * @return float|null
     */
    public function colorimetricValue(){
        if ($this->colorimetricMethod() && $this->calibration_value != 1) {
            if($calibrationMeasurement = $this->previousCalibrationMeasurement()){
                return $this->metricColorimetryValue() / $calibrationMeasurement->metricColorimetryValue();
            }
        }
        return null;
    }

    /**
     * Calculation for Colorimetric Spectrum for a given Metric UNCALIBRATED
     * Updated 4/14/22   uses extractWhiteBalanceClearNormalize
     * @return float
     */
    public function metricColorimetryValue(){
        $sum = 0;
        if ($this->colorimetricMethod()) {
            $this->extractWhiteBalanceClearNormalize();
            switch ($this->metric){
                case 'alkalinity':
                    // yellow & green absorption spectra best fit 4/14/22
//                     $sum += $this->violet;
//                     $sum += $this->indigo;
//                     $sum += $this->blue;
//                     $sum += $this->cyan;
                     $sum += $this->green;
                     $sum += $this->yellow;
//                     $sum += $this->orange;
//                     $sum += $this->red;
                    break;
                case 'free chlorine':
                    // cyan spectrum
//                    $sum += $this->violet;
//                    $sum += $this->indigo;
//                    $sum += $this->blue;
                    $sum += $this->cyan;
//                    $sum += $this->green;
//                    $sum += $this->yellow;
//                    $sum += $this->orange;
//                    $sum += $this->red;
                    break;
                case 'total chlorine':
                    // indigo spectrum
//                    $sum += $this->violet;
                    $sum += $this->indigo;
//                    $sum += $this->blue;
//                    $sum += $this->cyan;
//                    $sum += $this->green;
//                    $sum += $this->yellow;
//                    $sum += $this->orange;
//                    $sum += $this->red;
                    break;
                case 'calcium':
//                    $sum += $this->violet;
//                    $sum += $this->indigo;
//                    $sum += $this->blue;
//                    $sum += $this->cyan;
                    $sum += $this->green;
//                    $sum += $this->yellow;
//                    $sum += $this->orange;
//                    $sum += $this->red;
                    break;
                case 'ph':
//                    $sum += $this->violet;
//                    $sum += $this->indigo;
//                    $sum += $this->blue;
//                    $sum += $this->cyan;
                    $sum += $this->green;       // Per Phenol Red absoption at 550nm
//                    $sum += $this->yellow;
//                    $sum += $this->orange;
//                    $sum += $this->red;
                    break;
                default:
                    break;
            }
        }
        return $sum;
    }

    /**
     * Find the previous Calibration value - Used for Colorimetric Only
     * @return Measurement|\Illuminate\Database\Eloquent\Builder|Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function previousCalibrationMeasurement(){

        return Measurement::query()
            ->where('calibration_value',1)
            ->where('bumblebee_id',$this->bumblebee_id)
            ->where('measurement_timestamp', '<', $this->measurement_timestamp)
            ->where('method',$this->method)
            ->where('metric',$this->metric)
            ->orderBy('measurement_timestamp','desc')
            ->first();
    }

    /**
     * Find the previous Manual value
     * @return Measurement|\Illuminate\Database\Eloquent\Builder|Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function previousManualMeasurement(){

        $m =  Measurement::query()
            ->where('bumblebee_id',$this->bumblebee_id)
            ->where('metric',$this->metric)
            ->where('method','like', '%'.'manual'.'%')
            ->where('measurement_timestamp', '<', $this->measurement_timestamp)
            ->orderBy('measurement_timestamp','desc')
            ->first();

        return $m;

    }

    /**
     * Find the next Manual value
     * @return Measurement|\Illuminate\Database\Eloquent\Builder|Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function nextManualMeasurement(){

        return Measurement::query()
            ->where('bumblebee_id',$this->bumblebee_id)
            ->where('metric',$this->metric)
            ->where('method','like', '%'.'manual'.'%')
            ->where('measurement_timestamp', '>', $this->measurement_timestamp)
            ->orderBy('measurement_timestamp','desc')
            ->first();
    }

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
     * Valid Output Units for a given Metric
     * @param $metric
     * @return string[]
     */
    public function validOutputUnitsForMetric($metric = null){

        if ($metric == null) $metric = $this->metric;

        return match ($metric) {
            'conductivity' => ['uS/cm', 'mS/cm'],
            'free chlorine', 'total chlorine', 'alkalinity', 'calcium' => ['ppm', 'ppb'],
            'temperature' => ['F', 'C'],
            'pressure' => ['bar', 'psi', 'atm', 'Pa'],
            'flow' => ['gpm', 'cfs'],
            'orp' => ['V', 'mV'],
            default => ['none'],
        };
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
     * @param $method string if empty uses class value
     * @return bool if a manual Method
     */
    public function isManualMethod($method = null){
        if($method == null) $method = $this->method;
        return match ($method) {
            'manual_titration', 'manual_colorimetric', 'manual_teststrip', 'manual_probe' => true,
            default => false,
        };
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
            case 'manual_probe':
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
//            debugbar()->info('ID: '.$this->id.' value: '.$this->value);
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
     * Return Just the Colorimetric Data Scaled or Not Raw
     * @param int $scaled 1 = clear ref, 2 = maximum reference
     * @return Measurement|null
     */
    public function valueDecodeColor($scaled = 0){

        if($this->colorimetricMethod()){
            $copyMeas = $this;
            $copyMeas->extractToColors();
            if ($scaled > 0){
                $reference = $copyMeas->clear;
                if ($scaled == 2)
                    $reference = $this->maximumColorValue();
                $copyMeas->divideAllColorsByFloat($reference);
            }
            return $copyMeas;
        }
        return null;
    }

    /**
     * Extract Color Values and Normalize to previous Calibration Measurement
     * @return bool success
     */
    public function  extractWhiteBalanceClearNormalize(){
           $this->extractToColors();
           $prevCalMeas = $this->previousCalibrationMeasurement();
           if ($prevCalMeas) {
               $prevCalMeas->extractToColors();
               $prevCalMeas->divideAllColorsByFloat($prevCalMeas->maximumColorValue());
               $this->divideAllColorsByMeasurement($prevCalMeas);
               $this->divideAllColorsByClear();
               return true;
           }
           return false;
    }

    /**
     * Divide all the colors of THIS by another Measurements color values
     * @param Measurement $measDivisor
     * @return void
     */
    public function divideAllColorsByMeasurement(Measurement $measDivisor){
        try {
            $this->violet = round($this->violet / $measDivisor->violet, 4);
            $this->indigo = round($this->indigo / $measDivisor->indigo, 4);
            $this->blue = round($this->blue / $measDivisor->blue, 4);
            $this->cyan = round($this->cyan / $measDivisor->cyan, 4);
            $this->green = round($this->green / $measDivisor->green, 4);
            $this->yellow = round($this->yellow / $measDivisor->yellow, 4);
            $this->orange = round($this->orange / $measDivisor->orange, 4);
            $this->red = round($this->red / $measDivisor->red, 4);
            $this->nearIR = round($this->nearIR / $measDivisor->nearIR, 4);
        } catch (\Exception $e){
            return;
        } finally {
            return;
        }
    }

    /**
     * Divide all the colors by $divisor
     * @return void
     */
    public function divideAllColorsByFloat(float $divisor){

        $this->violet = round($this->violet / $divisor, 4);
        $this->indigo = round($this->indigo / $divisor, 4);
        $this->blue = round($this->blue / $divisor, 4);
        $this->cyan = round($this->cyan / $divisor, 4);
        $this->green = round($this->green / $divisor, 4);
        $this->yellow = round($this->yellow / $divisor, 4);
        $this->orange = round($this->orange / $divisor, 4);
        $this->red = round($this->red / $divisor, 4);
        $this->nearIR = round($this->nearIR / $divisor, 4);
    }

    /**
     * Divide all colors by Clear Color Value
     * @return void
     */
    public function divideAllColorsByClear(){
        $this->divideAllColorsByFloat($this->clear);
    }

    /**
     * Return the maximum value of Color
     * Colors must be extracted FIRST
     * @return float 0 if no colors found
     */
    public function maximumColorValue()
    {
        if ($this->colorimetricMethod()){

            $max = $this->violet;

            if ($this->indigo > $max) {
                $max = $this->indigo;
            }
            if ($this->blue > $max) {
                $max = $this->blue;
            }
            if ($this->cyan > $max) {
                $max = $this->cyan;
            }
            if ($this->green > $max) {
                $max = $this->green;
            }
            if ($this->yellow > $max) {
                $max = $this->yellow;
            }
            if ($this->orange > $max) {
                $max = $this->orange;
            }
            if ($this->red > $max) {
                $max = $this->red;
            }
            return $max;
        }
        return 0;
    }

    /**
     * Extract the JSON Color Values to individual colors in THIS
     * @return void
     */
    public function extractToColors(){

        $c = json_decode($this->forceDoubleQuotedJSON())->value;

        $this->violet = $c->violet;
        $this->indigo = $c->indigo;
        $this->blue = $c->blue;
        $this->cyan = $c->cyan;
        $this->green = $c->green;
        $this->yellow = $c->yellow;
        $this->orange = $c->orange;
        $this->red = $c->red;
        $this->nearIR = $c->nearIR;
        $this->clear = $c->clear;
    }


    /**
     * Search for specific measurements(s) across all visible fields
     *
     * @param string $search
     * @return Measurement|\Illuminate\Database\Eloquent\Builder
     */
    public static function searchView(int $bumblebeeID,
                                      string $metric,
                                      string $method,
                                      string $type,
                                      string $start_datetime,
                                      string $end_datetime,
                                      string $sort_by,
                                      string $orderAscending){

        $bumblebee_search_operator = "=";
        if($bumblebeeID == 0) $bumblebee_search_operator = "!=";

        $metric_search_operator = "=";
        if($metric == "all") $metric_search_operator = "!=";

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

        // this is for actual measurements
        $calibrated_search_operator = ">";
        if($type == "3"){
            debugbar()->info('Actual Measurement Query');

            return static::query()
                ->where('bumblebee_id', $bumblebee_search_operator, $bumblebeeID)
                ->where('metric', $metric_search_operator, $metric)
                ->where('calibration_value', '=', 0)
                ->where('measurement_timestamp', '>', $start_datetime)
                ->where('measurement_timestamp', '<', $end_datetime)
                ->where('calibration_id' ,'>' , 0)
                ->where('method', $method_search_operator, $method)
//                ->orWhere('method', 'like', '%manual%')
                ->orderBy($sort_by, $orderAscending );
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



}
