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

    public static function bumblebeeIdLastMeasurement(int $bb_id): Measurement|null {
        return Measurement::query()
            ->where('bumblebee_id', $bb_id)
            ->orderBy('measurement_timestamp', 'desc')
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
    /**
     * Return an array of all the metrics (measurements and calculations)
     * @return array[]
     */
    public static function allMetricsTable(){
        return array(
            ['metric' => 'ph', 'method' => 'probe', 'order' => 0, 'unit' => '', 'displayDefault' => true, 'values' =>array(), 'holdOver' =>array(), 'none' => array(), 'dataType' => array() ],
            ['metric' => 'orp', 'method' => 'probe', 'order' => 1, 'unit' => 'mV', 'displayDefault' => true, 'values' =>array(), 'holdOver' =>array(), 'none' => array(), 'dataType' => array() ],
            ['metric' => 'ph', 'method' => 'colorimetric', 'order' => 2, 'unit' => '', 'displayDefault' => true, 'values' =>array(), 'holdOver' =>array(), 'none' => array(), 'dataType' => array() ],
            ['metric' => 'conductivity', 'method' => 'probe', 'order' => 3, 'unit' => 'uS/cm', 'displayDefault' => true, 'values' =>array(), 'holdOver' =>array(), 'none' => array(), 'dataType' => array() ],
            ['metric' => 'salinity', 'method' => 'calculation', 'order' => 4, 'calculation' => 'salinity', 'unit' => 'ppm', 'displayDefault' => true, 'values' =>array(), 'holdOver' =>array(), 'none' => array(), 'dataType' => array() ],
            ['metric' => 'TDS', 'method' => 'calculation', 'order' => 5, 'calculation' => 'tds', 'unit' => 'ppm', 'displayDefault' => true, 'values' =>array(), 'holdOver' =>array(), 'none' => array(), 'dataType' => array() ],
            ['metric' => 'TDS-x', 'method' => 'calculation', 'order' => 6, 'calculation' => 'tdsIndex', 'unit' => '', 'displayDefault' => true, 'values' =>array(), 'holdOver' =>array(), 'none' => array(), 'dataType' => array() ],
            ['metric' => 'temperature', 'method' => 'probe', 'order' => 7, 'unit' => 'F', 'displayDefault' => true, 'values' =>array(), 'holdOver' =>array(), 'none' => array(), 'dataType' => array() ],
            ['metric' => 'temperature-x', 'method' => 'calculation', 'order' => 8, 'calculation' => 'temperatureIndex', 'unit' => '', 'displayDefault' => true, 'values' =>array(), 'holdOver' =>array(), 'none' => array(), 'dataType' => array() ],
            ['metric' => 'pressure', 'method' => 'probe', 'order' => 9, 'unit' => 'psi', 'displayDefault' => true, 'values' =>array(), 'holdOver' =>array(), 'none' => array(), 'dataType' => array() ],
            ['metric' => 'free chlorine', 'method' => 'colorimetric', 'order' => 10, 'unit' => 'ppm', 'displayDefault' => true, 'values' =>array(), 'holdOver' =>array(), 'none' => array(), 'dataType' => array() ],
            ['metric' => 'total chlorine', 'method' => 'colorimetric', 'order' => 11, 'unit' => 'ppm', 'displayDefault' => true, 'values' =>array(), 'holdOver' =>array(), 'none' => array(), 'dataType' => array() ],
            ['metric' => 'alkalinity', 'method' => 'colorimetric', 'order' => 12, 'unit' => 'ppm', 'displayDefault' => true, 'values' =>array(), 'holdOver' =>array(), 'none' => array(), 'dataType' => array() ],
            ['metric' => 'alkalinity-x', 'method' => 'calculation', 'order' => 13, 'calculation' => 'alkalinityIndex', 'unit' => '', 'displayDefault' => true, 'values' =>array(), 'holdOver' =>array(), 'none' => array(), 'dataType' => array() ],
            ['metric' => 'calcium', 'method' => 'colorimetric', 'order' => 14, 'unit' => 'ppm', 'displayDefault' => true, 'values' =>array(), 'holdOver' =>array(), 'none' => array(), 'dataType' => array() ],
            ['metric' => 'calcium-x', 'method' => 'calculation', 'order' => 15, 'calculation' => 'calciumIndex', 'unit' => '', 'displayDefault' => true, 'values' =>array(), 'holdOver' =>array(), 'none' => array(), 'dataType' => array() ],
            ['metric' => 'LSI', 'method' => 'calculation', 'order' => 16, 'calculation' => 'lsi', 'unit' => '', 'displayDefault' => true, 'values' =>array(), 'holdOver' =>array(), 'none' => array(), 'dataType' => array() ],
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
     * Find all non-calibration Measurements bow/metric/method between two times
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
    /**
     * Find first non-calibration Measurement bow/metric/method alder than a time
     * @param int $bow_id
     * @param string $metric
     * @param string $method
     * @param string $startTime
     * @return Measurement|\Illuminate\Database\Eloquent\Builder|Model|\Illuminate\Database\Query\Builder|object|null
     */
    public static function oneNewestNonCalibrationOlderThanforMetricMethodBowId(int $bow_id, string $metric, string $method, string $startTime){
        return Measurement::query()
            ->where('calibration_value', 0)
            ->where('bodies_of_water_id', $bow_id)
            ->where('metric', $metric)
            ->where('method', $method)
            ->where('measurement_timestamp', '<=', $startTime)
            ->orderBy('measurement_timestamp', 'desc')
            ->first();
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
    /**
     * Oldest non-calibration measurement for bow between two times
     * @param int $bow_id
     * @return Measurement|\Illuminate\Database\Eloquent\Builder|Model|\Illuminate\Database\Query\Builder|object|null
     */
    public static function oldestNonCalibrationMeasurementforBowID(int $bow_id){
        return Measurement::query()
            ->where('bodies_of_water_id', $bow_id)
            ->where('calibration_value', 0)
            ->orderBy('measurement_timestamp', 'asc')
            ->first();
    }

    // CALCULATIONS  - todo: these calculations may need to be put somewhere else eventually
    /**
     * Convert F to C Temperature
     * @param float $tempF
     * @return float temperature in C
     */
    public static function temperatureFtoC(float $tempF){
        return ($tempF - 32) * 0.55555555555;
    }
    /**
     * Convert C to F Temperature
     * @param float $tempC
     * @return float temperature in F
     */
    public static function temperatureCtoF(float $tempC){
        return ($tempC * 1.8) +32;
    }

    /**
     * Convert Conductivity to Salt Concentration
     * @param float $conductivity in  uS/cm
     * @return float in mg/L
     *
     * url: https://sciencing.com/convert-centimeters-meters-5329285.html
     */
    public static function salinityFromConductivity(float $conductivity): float {
        return ($conductivity/1000 ** 1.0878) * 0.4665 * 1000;
    }
    /**
     * Convert Conductivity to Total Dissolved Solids
     * @param float $conductivity assume in uS/cm
     * @return float total dissolved solids  in mg/L
     */
    public static function totalDissolvedSolidsFromConductivity(float $conductivity): float {
        return $conductivity * 0.4216286 - 0.0016286; // from EE spreadsheet todo: may want to remove the offset
    }
    /**
     * Convert TDS to TDS Index
     * @param float $tds
     * @return float
     */
    public static function tdsIndexFromTDS(float $tds): float {
        return (log10($tds) - 1) / 10;
    }
    /**
     * Convert Temperature in C to Temperature Index
     * @param float $tempC
     * @return float temperature Index
     */
    public static function temperatureIndex(float $tempC){
        return -13.12 * log10($tempC + 273) + 34.55;
    }
    /**
     * Convert Alkalinity to Alkalinity Index
     * @param float $alk
     * @return float
     */
    public static function alkalinityIndex(float $alk): float {
        if ($alk == 0) return 1;
        return log10($alk);
    }
    /**
     * Convert Calcium to Calcium Index
     * @param float $calcium
     * @return float
     */
    public static function calciumIndex(float $calcium): float {
        if ($calcium == 0) return 0.4;
        return log10($calcium) - 0.4;
    }
    /**
     * Calculate the LSI
     * @param float $pH
     * @param float $tdsIndex
     * @param float $tempIndex
     * @param float $calciumIndex
     * @param float $alkalinityIndex
     * @return float
     */
    public static function lsIndex(float $pH, float $tdsIndex, float $tempIndex, float $calciumIndex, float $alkalinityIndex): float {
        return $pH - (9.3 + $tdsIndex + $tempIndex) - ($calciumIndex + $alkalinityIndex);
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

    // Metric Table Static Methods

    /**
     * Find a specific metric/method pair in a given Metric Table
     * @param array $metricTable
     * @param string $metric
     * @param string $method
     * @return array|null
     */
    public static function findMetricMethodInMetricsTable(array $metricTable, string $metric, string $method){
        for($i = 0; $i < count($metricTable); $i++){
            if ($metric == $metricTable[$i]['metric'] && $method == $metricTable[$i]['method'])
                return $metricTable[$i];
        }
        return null;
    }
    /**
     * Return a Body of Water's Table of Raw or Calibrated - Taken and Calculated Measurements Grouped by Time Slots
     * @param int $bow_id
     * @param array $timeSlots array of N+1 times in mySql datetime format
     * @param string $data_type enum of 'raw' or
     * @return array[]
     */
    public static function fillMetricsTable(int $bow_id, array $timeSlots, string $data_type ){
        $metricsTable = self::allMetricsTable();

        // first pass for non-calculated measurements
        for($mtd = 0; $mtd < count($metricsTable); $mtd++){

            if ($metricsTable[$mtd]['method'] != 'calculation') {

                $metricsTable[$mtd]['values'] = array();
                $metricsTable[$mtd]['holdOver'] = array();
                $metricsTable[$mtd]['none'] = array();
                $metricsTable[$mtd]['dataType'] = array();

                for ($ts = 0; $ts < count($timeSlots) - 1; $ts++) {

                    // if actual readings, will bring in those readings here

                    $metricsTable[$mtd]['holdOver'][$ts] = false;
                    $metricsTable[$mtd]['none'][$ts] = false;

                    // get all the relevant Measurements between two times (could be zero if none in range)
                    $tempMeasArray = Measurement::allNonCalibrationBetweenTimesforMetricMethodBowId(
                        $bow_id,
                        $metricsTable[$mtd]['metric'],
                        $metricsTable[$mtd]['method'],
                        $timeSlots[$ts],
                        $timeSlots[$ts + 1]);


                    // look further back if no measurements
                    if (count($tempMeasArray) == 0) {
                        $tempMeasArray[] = Measurement::oneNewestNonCalibrationOlderThanforMetricMethodBowId(
                            $bow_id,
                            $metricsTable[$mtd]['metric'],
                            $metricsTable[$mtd]['method'],
                            $timeSlots[$ts + 1]
                        );
                        // empty the array if query returns null
                        if ($tempMeasArray[0] == null) {
                            $metricsTable[$mtd]['none'][$ts] = true;
                            $tempMeasArray = array();
                        }
                        $metricsTable[$mtd]['holdOver'][$ts] = true;   // mark this as a holdover
                    }

                    // average all measurements within the timeSlot
                    $valueAverage = 0;
                    for ($m = 0; $m < count($tempMeasArray); $m++) {
                        // raw or calibrated value
                        if ($data_type == "raw") {
                            $metricsTable[$mtd]['dataType'][$ts] = 'raw';
                            if ($tempMeasArray[$m]->colorimetricMethod()) {
                                $valueAverage += $tempMeasArray[$m]->metricColorimetryValue();
                            } elseif ($tempMeasArray[$m]->probeMethod()) {
                                $valueAverage += $tempMeasArray[$m]->valueDecodeNumber();
                            }
                        } else {
                            // Use the calibrated/actual value
                            $metricsTable[$mtd]['dataType'][$ts] = 'cal';
                            $valueAverage += $tempMeasArray[$m]->calibrated_value;
                        }
                    }

                    // return the average OR 0.0 if no reading
                    if (count($tempMeasArray)) {
                        $valueAverage = $valueAverage / count($tempMeasArray);
                        $metricsTable[$mtd]['values'][$ts] = $valueAverage;
                    } else {
                        // no measurements in this entry
                        $metricsTable[$mtd]['values'][$ts] = 0.0;
                        $metricsTable[$mtd]['none'][$ts] = true;
                        if ($data_type == "raw") {
                            $metricsTable[$mtd]['dataType'][$ts] = 'raw';
                        } else {
                            $metricsTable[$mtd]['dataType'][$ts] = 'cal';
                        }
                    }
                    // check if values is NAN and replace
                    if (is_nan($metricsTable[$mtd]['values'][$ts])){
                        $metricsTable[$mtd]['values'][$ts] = 0.0;
                        $metricsTable[$mtd]['none'][$ts] = true;
                    }
                }
            }
        }

        // second pass for calculated measurements
        for($mtd = 0; $mtd < count($metricsTable); $mtd++){

            if ($metricsTable[$mtd]['method'] == 'calculation') {

                $metricsTable[$mtd]['values'] = array();
                $metricsTable[$mtd]['holdOver'] = array();
                $metricsTable[$mtd]['none'] = array();
                $metricsTable[$mtd]['dataType'] = array();

                // todo: what do we want to do with calculations there are 'raw' only?

                for ($ts = 0; $ts < count($timeSlots) - 1; $ts++) {

                    $metricsTable[$mtd]['holdOver'][$ts]  = false;
                    $metricsTable[$mtd]['none'][$ts]  = false;
                    $metricsTable[$mtd]['dataType'][$ts] = 'calc';

                    if ($data_type == 'raw') {
                        $metricsTable[$mtd]['values'][$ts] = 0;
                        $metricsTable[$mtd]['none'][$ts] = true;
                    } else {
                        $metricsTable[$mtd]['none'][$ts] = true;
                        // if a calculation will perform calculation here AFTER Measurements are populated
                        switch ($metricsTable[$mtd]['calculation']) {
                            case 'tds':
                                $metricsTable[$mtd]['values'][$ts] = self::totalDissolvedSolidsFromConductivity(
                                    self::findMetricMethodInMetricsTable($metricsTable, 'conductivity', 'probe')['values'][$ts]);
                                $metricsTable[$mtd]['none'][$ts] = false;
                                break;
                            case 'tdsIndex':
                                $tds = self::totalDissolvedSolidsFromConductivity(
                                    self::findMetricMethodInMetricsTable($metricsTable, 'conductivity', 'probe')['values'][$ts]);
                                $metricsTable[$mtd]['values'][$ts] = self::tdsIndexFromTDS($tds);
                                $metricsTable[$mtd]['none'][$ts] = false;
                                break;
                            case 'salinity':
                                $metricsTable[$mtd]['values'][$ts] = self::salinityFromConductivity(
                                    self::findMetricMethodInMetricsTable($metricsTable, 'conductivity', 'probe')['values'][$ts]);
                                $metricsTable[$mtd]['none'][$ts] = false;
                                break;
                            case 'temperatureIndex':
                                $metricsTable[$mtd]['values'][$ts] = self::temperatureIndex(
                                    self::temperatureFtoC(self::findMetricMethodInMetricsTable($metricsTable, 'temperature', 'probe')['values'][$ts])
                                );
                                $metricsTable[$mtd]['none'][$ts] = false;
                                break;
                            case 'alkalinityIndex':
                                $metricsTable[$mtd]['values'][$ts] = self::alkalinityIndex(
                                    self::findMetricMethodInMetricsTable($metricsTable, 'alkalinity', 'colorimetric')['values'][$ts]);
                                $metricsTable[$mtd]['none'][$ts] = false;
                                break;
                            case 'calciumIndex':
                                $metricsTable[$mtd]['values'][$ts] = self::calciumIndex(
                                    self::findMetricMethodInMetricsTable($metricsTable, 'calcium', 'colorimetric')['values'][$ts]);
                                $metricsTable[$mtd]['none'][$ts] = false;
                                break;
                            case 'lsi':
                                $ph = self::findMetricMethodInMetricsTable($metricsTable, 'ph', 'probe')['values'][$ts];
                                $tdsIndex = self::findMetricMethodInMetricsTable($metricsTable, 'TDS-x', 'calculation')['values'][$ts];
                                $temperatureIndex = self::findMetricMethodInMetricsTable($metricsTable, 'temperature-x', 'calculation')['values'][$ts];
                                $calciumIndex = self::findMetricMethodInMetricsTable($metricsTable, 'calcium-x', 'calculation')['values'][$ts];
                                $alkalinityIndex = self::findMetricMethodInMetricsTable($metricsTable, 'alkalinity-x', 'calculation')['values'][$ts];
                                $metricsTable[$mtd]['values'][$ts] = self::lsIndex(
                                    $ph,
                                    $tdsIndex,
                                    $temperatureIndex,
                                    $calciumIndex,
                                    $alkalinityIndex);
                                $metricsTable[$mtd]['none'][$ts] = false;
                                break;
                            default:
                                $metricsTable[$mtd]['values'][$ts] = '-???-';
                                break;
                        }
                    }
                    // check if values is NAN and replace
                    if (is_nan($metricsTable[$mtd]['values'][$ts])){
                        $metricsTable[$mtd]['values'][$ts] = 0.0;
                        $metricsTable[$mtd]['none'][$ts] = true;
                    }
                }
            }
        }
        return $metricsTable;
    }

    /**
     * Calibrate THIS Measurement and Save
     * @return bool true if calibrated successful and saved (even if calibration is removed)
     * @throws \Throwable
     */
    public function calibrate():bool {

        if ($this->calibration_id) {
            if ($this->calibration->effective) {
                if ($this->doTheCalibrationMath()) {
                    $this->patch_UnsetAddedColorimetricFields();    // todo: fix this patch
                    return $this->updateOrFail(); // catch any error on the calling function to this!
                }
                return false;
            }
        } elseif ($calibration_id = $this->getEffectiveCalibration()->id) {
            $this->calibration_id = $calibration_id;
            if ($this->doTheCalibrationMath()) {
                $this->patch_UnsetAddedColorimetricFields(); // todo: fix this patch
                return $this->updateOrFail(); // catch any error on the calling function to this!
            }
            return false;
        }

        $this->clearTheCalibration();
        return $this->updateOrFail();
    }

    /**
     * Patch to fix the colorimetric attributed added by doTheCalibrationMath()
     * @return void
     */
    public function patch_UnsetAddedColorimetricFields(){
        unset($this->violet);
        unset($this->indigo);
        unset($this->blue);
        unset($this->cyan);
        unset($this->green);
        unset($this->yellow);
        unset($this->orange);
        unset($this->red);
        unset($this->nearIR);
        unset($this->clear);
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
               $prevCalMeas->extractToColors();                                         // extract all colors to temporary values
               $prevCalMeas->divideAllColorsByFloat($prevCalMeas->maximumColorValue()); // normalize to the maximum COLOR in the previous measurement (all values 0->1)
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
            debugbar()->info($this->attributesToArray());
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

        try {
            $this->violet = round($this->violet / $divisor, 4);
            $this->indigo = round($this->indigo / $divisor, 4);
            $this->blue = round($this->blue / $divisor, 4);
            $this->cyan = round($this->cyan / $divisor, 4);
            $this->green = round($this->green / $divisor, 4);
            $this->yellow = round($this->yellow / $divisor, 4);
            $this->orange = round($this->orange / $divisor, 4);
            $this->red = round($this->red / $divisor, 4);
            $this->nearIR = round($this->nearIR / $divisor, 4);
        } catch (\Exception $exception){
            debugbar()->info($this->attributesToArray());
            return;
        } finally {
            return;
        }
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
