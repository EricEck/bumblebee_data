<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address_primary_id',
        'billing_same_as_address',
        'address_billing_id',
        'contact_primary_id',
        'contact_billing_id',
        'contact_technical_id',
        'contact_service_id',
        'phone_office',
        'phone_fax',
        'email_primary',
        'website_url',
    ];

    // Eloquent Relationships
    public function members(){
        return $this->hasManyThrough(User::class, ServiceCompanyEmployee::class );
    }
    public function contactPrimary(){
        return $this->hasOneThrough(
            User::class,
            ServiceCompanyEmployee::class,
            'service_company_id',
            'id',
            'contact_primary_id');
    }
    public function contactBilling(){
        return $this->hasOneThrough(
            User::class,
            ServiceCompanyEmployee::class,
            'service_company_id',
            'id',
            'contact_billing_id');
    }
    public function contactTechnical(){
        return $this->hasOneThrough(
            User::class,
            ServiceCompanyEmployee::class,
            'service_company_id',
            'id',
            'contact_technical_id');
    }
    public function contactService(){
        return $this->hasOneThrough(
            User::class,
            ServiceCompanyEmployee::class,
            'service_company_id',
            'id',
            'contact_service_id');
    }
    public function locations(){
        return $this->hasManyThrough(Address::class, ServiceCompanyLocation::class);
    }
    public function addressPrimary(){
        return $this->hasOneThrough(
            Address::class,
            ServiceCompanyLocation::class,
            'service_company_id',
            'id',
            'address_primary_id',
        );
    }
    public function addressBilling(){
        return $this->hasOneThrough(
            Address::class,
            ServiceCompanyLocation::class,
            'service_company_id',
            'id',
            'address_billing_id',
        );
    }

}
