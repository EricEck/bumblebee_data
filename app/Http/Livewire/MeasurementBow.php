<?php

namespace App\Http\Livewire;

use App\Models\BodiesOfWater;
use App\Models\Measurement;
use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Component;

class MeasurementBow extends Component
{
    public $poolOwners;
    public $pool_owner_id;
    public $bodiesOfWater;
    public $bow_id;
    public bool $bodyOfWaterFound;
    public $bodyOfWater;
    public bool $measurementsFoundforBow;

    public Measurement $latestMeasurement, $oldestMeasurement;
    public Carbon $latestMeasurementTime, $oldestMeasurementTime, $latestDisplayMeasurementTime;
    public $timeSlots;
    public $timeSlotCount;
    public $minutesBetweenTimeSlots;

    public $data_display_type;

    public $metricsToDisplay;

    public bool $atNewest, $atOldest;



    // STANDARD LIVEWIRE METHODS

    public function mount(){
        debugbar()->info('mount: MeasurementBow');
        $this->poolOwners = User::allPoolOwners();
        $this->pool_owner_id = 0;
        $this->bodiesOfWater = BodiesOfWater::all();
        $this->bow_id = 0;
        $this->bodyOfWaterFound = false;
        $this->measurementsFoundforBow = false;
        $this->timeSlotCount = 4;
        $this->minutesBetweenTimeSlots = 15;
        $this->data_display_type = "raw";
    }
    public function render(){
        if ($this->timeSlots) {
            $this->atNewest = $this->timeSlotsContainNewestMeasurement();
            $this->atOldest = $this->timeSlotsContainOldestMeasurement();
        }

        debugbar()->info('render: MeasurementBow');
        return view('livewire.measurement-bow');
    }
    public function changed($what = ''){
        debugbar()->info('changed: MeasurementBow:: '.$what);

        switch ($what){
            case ('pool_owner_id'):
                if($this->pool_owner_id == -1){
                    $this->bodiesOfWater = BodiesOfWater::all();
                } else {
                    $this->bodiesOfWater = BodiesOfWater::allForPoolOwnerId($this->pool_owner_id);
                }
                $this->bodyOfWaterFound = false;
                $this->measurementsFoundforBow = false;
                $this->bow_id = 0;
                break;
            case ('bow_id'):
                $this->bodyOfWaterFound = false;
                $this->measurementsFoundforBow = false;
                if($this->bodyOfWater = BodiesOfWater::find($this->bow_id)){
                    $this->bodyOfWaterFound = true;
                    $this->pool_owner_id = $this->bodyOfWater->owner->id;
                    if(Measurement::latestNonCalibrationMeasurementforBowID($this->bow_id)){
                        $this->measurementsFoundforBow = true;

                        $this->latestMeasurement = Measurement::latestNonCalibrationMeasurementforBowID($this->bow_id);
                        $this->oldestMeasurement = Measurement::oldestNonCalibrationMeasurementforBowID($this->bow_id);
                        $this->latestMeasurementTime = Carbon::parse($this->latestMeasurement->measurement_timestamp);
                        $this->oldestMeasurementTime = Carbon::parse($this->oldestMeasurement->measurement_timestamp);

                        $this->latestDisplayMeasurementTime = Carbon::parse($this->latestMeasurement->measurement_timestamp);
                        $this->getNearestTimeRoundedUp($this->latestDisplayMeasurementTime, $this->minutesBetweenTimeSlots);

                        $this->updateMinutesBetweenSlots($this->minutesBetweenTimeSlots);
                    }
                }
                break;
            case ('minutes_between_slots'):
                $this->updateMinutesBetweenSlots($this->minutesBetweenTimeSlots);
                break;
            case ('data_display_type'):
                $this->generateMetricsToDisplay();
                break;
        }
    }

    // METHODS supporting Livewire

    public function olderShift(){
        $this->shiftBodyOfWaterDataTimeSlots( -1);
    }
    public function oldestShift(){
        $this->latestDisplayMeasurementTime = Carbon::parse($this->oldestMeasurement->measurement_timestamp);
        $this->getNearestTimeRoundedUp($this->latestDisplayMeasurementTime, $this->minutesBetweenTimeSlots);
        $this->latestDisplayMeasurementTime->addMinutes($this->minutesBetweenTimeSlots);
        $this->updateMinutesBetweenSlots($this->minutesBetweenTimeSlots);
    }
    public function newerShift(){
        $this->shiftBodyOfWaterDataTimeSlots( 1);
    }
    public function newestShift(){
        $this->latestDisplayMeasurementTime = Carbon::parse($this->latestMeasurement->measurement_timestamp);
        $this->getNearestTimeRoundedUp($this->latestDisplayMeasurementTime, $this->minutesBetweenTimeSlots);
        $this->updateMinutesBetweenSlots($this->minutesBetweenTimeSlots);
    }
    public function shiftBodyOfWaterDataTimeSlots( $slotsToShift){
        $this->latestDisplayMeasurementTime->addMinutes($this->minutesBetweenTimeSlots * $slotsToShift);

        $this->timeSlots = $this->generatePastMySqlTimeSlots(
            $this->latestDisplayMeasurementTime,
            $this->minutesBetweenTimeSlots,
            $this->timeSlotCount,
            $this->minutesBetweenTimeSlots);

        $this->generateMetricsToDisplay();
    }
    public function updateMinutesBetweenSlots($minutesBetweenTimeSlots){
        debugbar()->info('loadBodyOfWaterData: MeasurementBow');

        $this->timeSlots = $this->generatePastMySqlTimeSlots(
            $this->latestDisplayMeasurementTime,
            $this->minutesBetweenTimeSlots,
            $this->timeSlotCount,
            $minutesBetweenTimeSlots);

        $this->generateMetricsToDisplay();
    }

   private function generateMetricsToDisplay(){
        $this->metricsToDisplay = Measurement::displayMetricMethodUnits();

        for($mtd = 0; $mtd < count($this->metricsToDisplay); $mtd++){
            $this->metricsToDisplay[$mtd]['values'] = array();

            for($ts = 0; $ts < count($this->timeSlots) - 1; $ts++) {

                if($this->metricsToDisplay[$mtd]['method'] == 'calculation'){
                    // if a calculation will perform calculation here
                    if ($this->metricsToDisplay[$mtd]['calculation'] == 'tds'){
                        $this->metricsToDisplay[$mtd]['values'][] = '-tds-';
                    }
                    if ($this->metricsToDisplay[$mtd]['calculation'] == 'lsi'){
                        $this->metricsToDisplay[$mtd]['values'][] = '-lsi-';
                    }
//                    $this->metricsToDisplay[$mtd]['values'][] = '--';
                } else {
                    // if actual readings, will bring in those readings here

                    // get all the relevant measurements
                    $tempMeasArray = Measurement::allNonCalibrationBetweenTimesforMetricMethodBowId(
                        $this->bow_id,
                        $this->metricsToDisplay[$mtd]['metric'],
                        $this->metricsToDisplay[$mtd]['method'],
                        $this->timeSlots[$ts],
                        $this->timeSlots[$ts + 1]);

                    // TODO: Do we want to add a fetch here for latest OUTside the time measurement?

                    // average them
                    $valueAverage = 0;
                    for ($m = 0; $m < count($tempMeasArray); $m++) {
                        // raw or calibrated value
                        if($this->data_display_type == "raw") {
                            if ($tempMeasArray[$m]->colorimetricMethod()) {
                                $valueAverage += $tempMeasArray[$m]->metricColorimetryValue();
                            } elseif ($tempMeasArray[$m]->probeMethod()) {
                                $valueAverage += $tempMeasArray[$m]->valueDecodeNumber();
                            }
                        } else {
                            // Use the calibrated value
                            $valueAverage += $tempMeasArray[$m]->calibrated_value;
                        }
                    }
                    // return the average OR 'n/a' if no reading
                    if (count($tempMeasArray)) {
                        $valueAverage = $valueAverage / count($tempMeasArray);
                        $this->metricsToDisplay[$mtd]['values'][] = round($valueAverage, 3);
                    } else {
                        $this->metricsToDisplay[$mtd]['values'][] = 'n/a';
                    }
                }
            }
        }
    }

    /**
     * Generate an array of times
     * @param Carbon $startingTime
     * @param int $minRoundUp
     * @param int $numberOfSlots
     * @param int $minBetweenSlots
     * @return array
     */
    private function generatePastMySqlTimeSlots(Carbon $startingTime, int $minRoundUp = 15, int $numberOfSlots = 4, int $minBetweenSlots = 15){
        $timeVar = $startingTime->copy();
        $timeSlots = [];
        $timeSlots[] = $timeVar->toDateTimeString();
        for($i = 0; $i < $numberOfSlots; $i++ ){
            $timeVar->subMinutes($minBetweenSlots);
            $timeSlots[] = $timeVar->toDateTimeString();
        }
        return $timeSlots;
    }
    /**
     * Chunk Carbon time down to the nearest provided minutes
     * @param Carbon $now
     * @param int $minutesChunk
     * @return Carbon
     */
    private static function getNearestTimeRoundedDown($now, $minutesChunk = 30) {
        $newMinute = $now->minute - ($now->minute % $minutesChunk);
        return $now->minute($newMinute)->startOfMinute(); //https://carbon.nesbot.com/docs/
    }
    /**
     * Chunk Carbon time down to the nearest provided minutes
     * @param Carbon $now
     * @param int $minutesChunk
     * @return Carbon
     */
    private static function getNearestTimeRoundedUp($now, $minutesChunk = 30) {
        $newMinute = $now->minute + $minutesChunk - ($now->minute % $minutesChunk);
        return $now->minute($newMinute)->startOfMinute(); //https://carbon.nesbot.com/docs/
    }
    /**
     * TimeSlots contain the oldest Measurement Time
     * @return bool
     */
    private function timeSlotsContainOldestMeasurement(){
        $oldestTimeSlotTime = Carbon::parse($this->timeSlots[$this->timeSlotCount-1]);
        if ($this->oldestMeasurementTime > $oldestTimeSlotTime)
            return true;
        return false;
    }
    /**
     * TimeSlots contain the newest Measurement Time
     * @return bool
     */
    private function timeSlotsContainNewestMeasurement(){
        $newestTimeSlotTime = Carbon::parse($this->timeSlots[0]);
        if ($this->latestMeasurementTime < $newestTimeSlotTime)
            return true;
        return false;
    }

}
