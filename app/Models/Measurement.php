<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     * Elequent belongs to relationship Bumblebee Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bumblebee(){
        return $this->belongsTo(Bumblebee::class);
    }

}
