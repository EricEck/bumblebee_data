<?php

namespace App\Http\Livewire;

use App\Models\BodiesOfWater;
use App\Models\Measurement;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class MeasurementTable2 extends Component
{
    public BodiesOfWater $bodyOfWater;
    public int $bow_id;
    public Collection $bodiesOfWater;
    public bool $bodyOfWaterFound;

    public int $pool_owner_id;
    public Collection $poolOwners;


    public $measurements;

    public $metricsToDisplay;

    public Measurement $latestMeasurement;
    public Carbon $latestMeasurementTime;
    public string $newestTime;

    public array $params;   // for now just bow_id

    public $timeSlots;      // array of ending timeslots. always one more in length than timeslots needed
    public $timeSlotCount;
    public $minutesBetweenTimeSlots;

    public function mount(){
        debugbar()->info('mount: MeasurementTable2');
        $this->bodyOfWaterFound = false;
        $this->poolOwners = User::allPoolOwners();
        $this->pool_owner_id = 0;
        $this->bodiesOfWater = BodiesOfWater::all();
        $this->bow_id = 0;

        $this->timeSlotCount = 4;
        $this->minutesBetweenTimeSlots = 15;

        if($this->decodeParams()){
            // check if we have a url forced body of water
            if($this->bodyOfWater = BodiesOfWater::find(($this->bow_id))){
                $this->loadBodyOfWaterData();
                $this->pool_owner_id = $this->bodyOfWater->owner->id;
                $this->bodyOfWaterFound = true;
            }
        }
    }

    public function render(){

//        debugbar()->info($this->measurements);

        debugbar()->info('render: MeasurementTable2');
        debugbar()->info($this->metricsToDisplay);
        debugbar()->info($this->pool_owner_id);
        debugbar()->info($this->poolOwners);
        debugbar()->info($this->bow_id);
        debugbar()->info($this->bodiesOfWater);
        debugbar()->info($this->bodyOfWaterFound);

        return view('livewire.measurement-table2');
    }


    // General METHODS for this Livewire Component


    public function changed(string $what){
        debugbar()->info('changed: MeasurementTable -- '. $what);
//        $this->changed = true;

        switch ($what){
            case ('pool_owner_id'):
                $this->bow_id = 0;
                $this->bodyOfWaterFound = false;
//                $this->bodiesOfWater = BodiesOfWater::allForPoolOwnerId($this->pool_owner_id);
//                debugbar()->info($this->bodiesOfWater);
//                if($this->pool_owner_id == 0) {
//                    $this->bodiesOfWater = BodiesOfWater::all();
//                } else {
//                    $this->bodiesOfWater = BodiesOfWater::allForPoolOwnerId($this->pool_owner_id);
//                }
                break;
            case ('bow_id'):
                $this->bodyOfWaterFound = false;
                if($this->bodyOfWater = BodiesOfWater::find($this->bow_id)){
                    $this->pool_owner_id = $this->bodyOfWater->owner->id;
                    $this->bodyOfWaterFound = true;
                    $this->loadBodyOfWaterData();
                }
                break;
        }
    }


    public function loadBodyOfWaterData(){
        debugbar()->info('loadBodyOfWaterData:');

        if(!$this->latestMeasurement = Measurement::latestNonCalibrationMeasurementforBowID($this->bow_id))
            return false;

        $this->latestMeasurementTime = Carbon::parse($this->latestMeasurement->measurement_timestamp);

        $this->timeSlots = $this->generatePastMySqlTimeSlots(
            $this->latestMeasurementTime,
            $this->minutesBetweenTimeSlots,
            $this->timeSlotCount,
            $this->minutesBetweenTimeSlots);

        $this->newestTime = $this->timeSlots[0];

        $this->metricsToDisplay = Measurement::displayMetricMethodUnits();

        for($mtd = 0; $mtd < count($this->metricsToDisplay); $mtd++){
            $this->metricsToDisplay[$mtd]['values'] = array();
            for($ts = 0; $ts < count($this->timeSlots) - 1; $ts++) {

                if($this->metricsToDisplay[$mtd]['method'] == 'calculation'){
                    // if a calculation will perform calculation here
                    $this->metricsToDisplay[$mtd]['values'][] = '--';
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
//                    debugbar()->info('measurements:' . count($tempMeasArray));
                    for ($m = 0; $m < count($tempMeasArray); $m++) {

                        if ($tempMeasArray[$m]->colorimetricMethod()) {
//                            debugbar()->info('color');

                            $valueAverage += $tempMeasArray[$m]->metricColorimetryValue();
                        } elseif ($tempMeasArray[$m]->probeMethod()) {
//                            debugbar()->info('probe');
                            $valueAverage += $tempMeasArray[$m]->valueDecodeNumber();
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

        debugbar()->info($this->metricsToDisplay);
        return true;
    }

    /**
     * Decode the passed parameter array and populate index keys
     * @return bool success
     */
    public function decodeParams(){
        if (isset($this->params["bow_id"]))
            if($this->bow_id = urldecode($this->params["bow_id"])) {
                return true;
            }
        return false;
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
        $timeVar = $this->getNearestTimeRoundedUp($startingTime, 15);
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
}
