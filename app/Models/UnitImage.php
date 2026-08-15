<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitImage extends Model
{
    // السماح بحفظ هذه الحقول في قاعدة البيانات
    protected $fillable = [
        'unit_id',
        'file_path',
    ];

    // علاقة عكسية: كل صورة تنتمي لوحدة واحدة
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}