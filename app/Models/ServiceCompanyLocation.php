<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCompanyLocation extends Model
{
    use HasFactory;

   protected $fillable = [
       'service_company_id',
       'address_id',
       'name',
       'description',
       'active'
   ];

    // Eloquent Relationships
    public function serviceCompany(){
        return $this->hasOne(ServiceCompany::class);
    }
    public function address(){
        return $this->hasOne(Address::class);
    }

    /**
     * Is the user an active Address
     * @return boolean
     */
    public function isActive(){
        return $this->active;
    }

    /**
     * Activate an Address
     * @return bool
     * @throws \Throwable
     */
    public function activate(){
        $this->active = true;
        return $this->saveOrFail();
    }

    /**
     * Deactivate an Address
     * @return bool
     * @throws \Throwable
     */
    public function deActivate(){
        $this->active = false;
        return $this->saveOrFail();
    }

}
