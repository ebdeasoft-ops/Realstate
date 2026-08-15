<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
protected $fillable = [
    'owner_id', 'name', 'property_category', 'address', 'city', 'district', 
    'owner_id_number', 'owner_nationality', 'owner_phone', 'owner_landline', 
    'owner_address', 'owner_email', 'commission_rate', 'insurance_account', 
    'water_account', 'description','bank_name',      // جديد
    'account_number', // جديد
    'iban',           // جديد
];

    public function owner() {
        return $this->belongsTo(Owner::class);
    }

    public function units() {
        return $this->hasMany(Unit::class);
    }

    public function media() {
        return $this->hasMany(PropertyImage::class, 'property_id'); 
    }
}