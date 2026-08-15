<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    // توجيه المودل ليتعامل مع جدول customers الموجود في قاعدة البيانات
    protected $table = 'customers';

    protected $guarded = [];

    // علاقة المستأجر بالعقود
    public function contracts()
    {
        return $this->hasMany(LeaseContract::class, 'tenant_id');
    }
}