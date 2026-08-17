<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentInstallment extends Model
{
    protected $fillable = [
        'contract_id', 'unit_id', 'tenant_id', 'installment_number', 
        'amount', 'due_date', 'paid_date', 'status', 'notes', 'paid_amount','PaymentType'
    ];

    // علاقة القسط بالعقد
    public function contract()
    {
        return $this->belongsTo(LeaseContract::class, 'contract_id');
    }

    // علاقة القسط بالمستأجر (العميل)
    public function tenantData()
    {
        // استبدل Customer بـ Tenant إذا كان اسم الـ Model لديك Tenant
        return $this->belongsTo(customers::class, 'tenant_id');
    }
      public function UnitData()
    {
        // استبدل Customer بـ Tenant إذا كان اسم الـ Model لديك Tenant
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}