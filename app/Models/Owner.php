<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $fillable = [
        'name', 
        'phone', 
        'email', 
        'address', 
        'nationality',          // الجنسية
        'national_id',          // رقم الهوية
        'bank_name',            // اسم البنك
        'bank_account_number',  // رقم الحساب
        'iban'                  // رقم الآيبان
    ];

    public function properties() {
        return $this->hasMany(Property::class);
    }
}