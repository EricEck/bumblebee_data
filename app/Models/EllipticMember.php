<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EllipticMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'active',
    ];

    // Eloquent Relationships
    public function user(){
        return $this->hasOne(User::class);
    }

    /**
     * Is the user an active Elliptic Member
     * @return boolean
     */
    public function isActive(){
        return $this->active;
    }

    /**
     * Activate an Elliptic Member
     * @return bool
     * @throws \Throwable
     */
    public function activate(){
        $this->active = true;
        return $this->saveOrFail();
    }

    /**
     * Deactivate an Elliptic Member
     * @return bool
     * @throws \Throwable
     */
    public function deActivate(){
        $this->active = false;
        return $this->saveOrFail();
    }
}
