<?php

namespace App\Exports;

use App\Models\Measurement;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class MeasurementsExport implements FromQuery
{
    use Exportable;

    /**
     * @param int $bumblebeeID
     * @param string $metric
     * @param string $method
     * @param int $types
     * @param string $start_datetime
     * @param string $end_datetime
     * @param string $sort_by
     * @param int $orderAscending
     */

    public function __construct(int $bumblebeeID, string $metric, string $method, int $types,  string $start_datetime,  string $end_datetime, string $sort_by, string $orderAscending){
        $this->bumblebeeID = $bumblebeeID;
        $this->metric = $metric;
        $this->method = $method;
        $this->types = $types;
        $this->start_datetime = $start_datetime;
        $this->end_datetime = $end_datetime;
        $this->sort_by = $sort_by;
        $this->orderAscending = $orderAscending;
    }

    /**
     * Find and Return Specific Measurements
     *
     * @return Measurement|EloquentBuilder|Relation|Builder
     */
    public function query(){

        return Measurement::searchView(
            $this->bumblebeeID,
            $this->metric,
            $this->method,
            $this->types,
            $this->start_datetime,
            $this->end_datetime,
            $this->sort_by,
            $this->orderAscending);
    }
}
