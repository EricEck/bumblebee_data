<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EllipticModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_bumblebee',
        'is_active',
    ];

    protected $casts = [];

    // default when new
    protected $attributes = [
        'name' => '',
        'description' => '',
        'is_bumblebee' => 0,
        'is_active' => 1,
    ];

    // eager load relationships
    protected $with = [];

    // Eloquent Relationships

    // METHODS

    /**
     * All Active Elliptic Product Models
     * @return EllipticModel[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public static function allActive(){
        return EllipticModel::query()
            ->where('is_active', 1)
            ->orderBy('name', 'asc')
            ->get();
    }

}
