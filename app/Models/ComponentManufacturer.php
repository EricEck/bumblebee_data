<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentManufacturer extends Model
{
    use HasFactory;

    // mass loading
    protected $fillable = [
        'name',
        'description',
        'website_main_url',
        'website_service_url',
        'is_elliptic_works',
    ];

    // predefined
    protected $attributes = [
        'name' => '',
        'description' => '',
        'website_main_url' => '',
        'website_service_url' => '',
        'is_elliptic_works' => 0,
    ];

    protected $casts = [
    ];

    // eager load
    protected $with = [
    ];

    // Eloquent Relationships


    // Methods

    public function filled(){
        return (
            strlen($this->name) > 2
        );
    }
    /**
     * Return All with Elliptic First
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function allEllipticFirst(){
        return ComponentManufacturer::query()
            ->orderBy('is_elliptic_works', 'desc')
            ->orderBy('name', 'asc')
            ->get();
    }
    /**
     * Elliptic Works
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public static function ellipticWorks(){
        return ComponentManufacturer::query()
            ->where('is_elliptic_works', 1)
            ->first();
    }
}
