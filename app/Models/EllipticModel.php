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
}
