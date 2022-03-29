<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCompanyEmployee extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_company_id',
        'user_id',
        'active',
    ];

    // Eloquent Relationships
    public function user(){
        return $this->hasOne(User::class);
    }
    public function serviceCompany(){
        return $this->hasOne(ServiceCompany::class);
    }

    /**
     * Is the user an active Service Company Member
     * @return boolean
     */
    public function isActive(){
        return $this->active;
    }

    /**
     * Activate a Service Company Member
     * @return bool
     * @throws \Throwable
     */
    public function activate(){
        $this->active = true;
        return $this->saveOrFail();
    }

    /**
     * Deactivate a Service Company Member
     * @return bool
     * @throws \Throwable
     */
    public function deActivate(){
        $this->active = false;
        return $this->saveOrFail();
    }

}
