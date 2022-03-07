<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromQuery
{
    use Exportable;

    /**
     * @param string $searchString
     * @param string $orderBy
     * @param int $orderAscending
     */
    public function __construct(string $searchString, string $orderBy, int $orderAscending){
        $this->searchString = $searchString;
        $this->orderBy = $orderBy;
        $this->orderAscending = $orderAscending;
    }

    public function forSearch(string $searchString = ''){
        $this->searchString = $searchString;
        return $this;
    }

    public function forOrder(string $orderBy = ''){
        $this->orderBy = $orderBy;
        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation|\Illuminate\Database\Query\Builder
     */
    public function query(){
        return User::searchView($this->searchString)
            ->orderBy($this->orderBy, $this->orderAscending ? 'asc' : 'desc');
    }
}
