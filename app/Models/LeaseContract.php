<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaseContract extends Model
{
    use HasFactory;

    protected $table = 'lease_contracts';

    protected $fillable = [
        'unit_id', 
        'tenant_id', 
        'start_date', 
        'end_date', 
        'rent_amount', 
        'insurance_amount', 
        'status',
        // الحقول الجديدة التي تم إضافتها لنموذج العقد:
        'contract_number',
        'contract_type',
        'electricity_meter',
        'contract_date',
        'payment_every',
        'installment_amount',
        'commission',
        'annual_commission', // العمولة السنوية
        'water_bill',
        'paid_amount',
        'represented_by',
        'guarantor_name',
        'guarantor_phone',
        'notes'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    // ربط العقد بجدول customers (المستأجر)
    public function tenant()
    {
        return $this->belongsTo(customers::class, 'tenant_id');
    }
}