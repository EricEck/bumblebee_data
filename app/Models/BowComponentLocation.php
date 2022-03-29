<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BowComponentLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        ];

    // Eloquent Relationships

    public function components(){
        return $this->hasMany(BowComponent::class, 'installation_location_id', 'id');
    }
}
