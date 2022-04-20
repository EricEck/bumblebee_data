<?php

namespace App\Http\Livewire;

use App\Models\BodiesOfWater;
use App\Models\Measurement;
use Illuminate\Support\Carbon;
use Livewire\Component;

class MeasurementTable2 extends Component
{
    public BodiesOfWater $bodyOfWater;
    public int $bow_id;

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

        if(!$this->decodeParams())
            abort(404); // not found

        $this->metricsToDisplay = Measurement::displayMetricMethodUnits();

        $this->timeSlotCount = 4;
        $this->minutesBetweenTimeSlots = 15;

        $this->latestMeasurement = Measurement::latestNonCalibrationMeasurementforBowID($this->bow_id);
        $this->latestMeasurementTime = Carbon::parse($this->latestMeasurement->measurement_timestamp);

        $this->timeSlots = $this->generatePastMySqlTimeSlots(
            $this->latestMeasurementTime,
            $this->minutesBetweenTimeSlots,
            $this->timeSlotCount,
            $this->minutesBetweenTimeSlots);

        $this->newestTime = $this->timeSlots[0];



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
                    debugbar()->info('measurements:' . count($tempMeasArray));
                    for ($m = 0; $m < count($tempMeasArray); $m++) {

                        if ($tempMeasArray[$m]->colorimetricMethod()) {
                            debugbar()->info('color');

                            $valueAverage += $tempMeasArray[$m]->metricColorimetryValue();
                        } elseif ($tempMeasArray[$m]->probeMethod()) {
                            debugbar()->info('probe');
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

//        $this->measurements = Measurement::allBetweenTimesforBowId(
//            $this->bow_id,
//            $this->timeSlots[0],
//            $this->timeSlots[1]
//        );


//        debugbar()->info('Body of Water ID: '.$this->bow_id);
//        debugbar()->info('Body of Water Last Measurement: '.$this->latestMeasurementTime->toDateTimeString());
//        debugbar()->info($this->bodyOfWater->name);
//        debugbar()->info($this->timeSlots);
    }

    public function render(){


//        debugbar()->info($this->measurements);

        debugbar()->info('render: MeasurementTable2');
        return view('livewire.measurement-table2');
    }


    // General METHODS for this Livewire Component

    /**
     * Decode the passed parameter array and populate variables
     * @return bool success
     */
    private function decodeParams(){
        if($this->bow_id = urldecode($this->params["bow_id"])) {
            if($this->bodyOfWater = BodiesOfWater::find(($this->bow_id))){
                return true;
            }
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
