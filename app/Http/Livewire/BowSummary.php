<?php

namespace App\Http\Livewire;

use App\Models\BodiesOfWater;
use App\Models\Measurement;
use Illuminate\Support\Carbon;
use Livewire\Component;

class BowSummary extends Component
{
    public int $bow_id;
    public BodiesOfWater $bow;
    public Measurement $latestMeasurement, $oldestMeasurement;
    public Carbon $latestMeasurementTime, $oldestMeasurementTime, $latestDisplayMeasurementTime;
    public array $measurements;
    public int $minutesAverage;
    public $timeSlots;
    public $timeSlotCount;
    public bool $measurementsFoundforBow;
    public $data_display_type;
    public $metricsToDisplay;

    public function mount(){
        if ($this->bow_id){
            $this->bow = BodiesOfWater::find($this->bow_id);
            debugbar()->info($this->bow->name);
            $this->minutesAverage = 60 *8;  // Average over 8 hours
            $this->timeSlotCount = 1;
            $this->data_display_type = "cal";
            $this->measurementsFoundforBow = false;
            $this->getMeasurements();

        } else {
            abort(403, 'Body of Water ID Not Found');
        }
    }

    public function render(){
        $m = Measurement::findInMetricsTable($this->metricsToDisplay, 'LSI', 'calculation');
        debugbar()->info($m);
        return view('livewire.bow-summary');
    }

    public function getMeasurements(){
        $this->latestMeasurement = Measurement::latestNonCalibrationMeasurementforBowID($this->bow_id);
        $this->oldestMeasurement = Measurement::oldestNonCalibrationMeasurementforBowID($this->bow_id);
        $this->latestMeasurementTime = Carbon::parse($this->latestMeasurement->measurement_timestamp);
        $this->oldestMeasurementTime = Carbon::parse($this->oldestMeasurement->measurement_timestamp);

        $this->latestDisplayMeasurementTime = Carbon::parse($this->latestMeasurement->measurement_timestamp);
        // 8 hour average
        $this->getNearestTimeRoundedUp($this->latestDisplayMeasurementTime, $this->minutesAverage);

        $this->updateMinutesBetweenSlots($this->minutesAverage);

        $this->generateMetricsToDisplay();
    }

    /**
     * Generate & Replace metricsToDisplay array based upon class variables
     * $this->>timeSlots
     * $this->data_display_type
     * @return void
     */
    private function generateMetricsToDisplay(){

        $this->metricsToDisplay = Measurement::fillMetricsTable(
            $this->bow_id,
            $this->timeSlots,
            $this->data_display_type);
    }

    public function updateMinutesBetweenSlots($minutesBetweenTimeSlots){
        debugbar()->info('BowSummary: updateMinutesBetweenSlots');

        $this->timeSlots = $this->generatePastMySqlTimeSlots(
            $this->latestDisplayMeasurementTime,
            $this->minutesAverage,
            $this->timeSlotCount,
            $minutesBetweenTimeSlots);


        $this->generateMetricsToDisplay();
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
    private static function getNearestTimeRoundedUp($now, $minutesChunk = 30) {
        $newMinute = $now->minute + $minutesChunk - ($now->minute % $minutesChunk);
        return $now->minute($newMinute)->startOfMinute(); //https://carbon.nesbot.com/docs/
    }
}
