<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id', 'unit_id', 'expense_type', 'amount', 'expense_date', 
        'payment_method', 'description', 'receipt_path'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // إضافة علاقة الوحدة هنا
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}