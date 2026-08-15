<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'property_id',
        'unit_number',
        'annual_rent',
        'is_rented',
        'status',              // مضاف حديثاً (الحالة)
        'unit_category',       // نوع الوحدة
        'finishing_type',      // نوع التشطيب
        'payment_method',      // طريقة دفع الإيجار
        'floor_number',        // رقم الدور
        'rooms_count',         // عدد الغرف
        'kitchens_count',      // عدد المطابخ
        'bathrooms_count',     // عدد دورات المياه
        'ac_status',           // حالة التكييف
        'description',         // المواصفات الإضافية / الملاحظات
        'electricity_meter', 
        'water_meter',       
        'ac_count',          
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function images()
    {
        return $this->hasMany(UnitImage::class);
    }
    public function activeContract()
    {
        return $this->hasOne(LeaseContract::class, 'unit_id')->where('status', 'active');
    }
}