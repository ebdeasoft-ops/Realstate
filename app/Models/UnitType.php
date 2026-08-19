<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitType extends Model
{
    use HasFactory;

    protected $table = 'unit_types';
    protected $fillable = ['name_ar', 'name_en'];

    // دالة مساعدة لجلبه حسب اللغة الحالية للموقع تلقائياً
    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $this->attributes['name_' . $locale] ?? $this->attributes['name_ar'];
    }

    public function units()
    {
        return $this->hasMany(Unit::class, 'unit_type_id', 'id');
    }
}