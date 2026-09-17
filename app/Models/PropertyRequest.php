<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyRequest extends Model
{
    use HasFactory;

    protected $table = 'property_requests';

    protected $fillable = [
        'customer_id',
        'client_name',
        'client_phone',
        'client_email',
        'national_id',
        'request_type',
        'unit_type_id',
        'city',
        'district',
        'min_price',
        'max_price',
        'rooms_count',
        'bathrooms_count',
        'floor_number',
        'finishing_type',
        'ac_status',
        'notes',
        'status',
        'matched_unit_id',
        'matched_property_id',
        'contact_notes',
        'last_contacted_at',
        'created_by',
    ];

    protected $casts = [
        'min_price' => 'decimal:2',
        'max_price' => 'decimal:2',
        'last_contacted_at' => 'datetime',
    ];

    // ==========================================================
    // العلاقات (Relationships)
    // ==========================================================

    public function customer()
    {
        return $this->belongsTo(customers::class, 'customer_id');
    }

    public function unitType()
    {
        return $this->belongsTo(UnitType::class, 'unit_type_id');
    }

    public function matchedUnit()
    {
        return $this->belongsTo(Unit::class, 'matched_unit_id');
    }

    public function matchedProperty()
    {
        return $this->belongsTo(Property::class, 'matched_property_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ==========================================================
    // الـ Scopes
    // ==========================================================

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeContacted($query)
    {
        return $query->where('status', 'contacted');
    }

    public function scopeFulfilled($query)
    {
        return $query->where('status', 'fulfilled');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    // ==========================================================
    // الدوال المساعدة للـ Accessors والتنسيق
    // ==========================================================

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'قيد الانتظار',
            'contacted' => 'جاري التواصل',
            'fulfilled' => 'تم التسكين وتوفير العقار',
            'cancelled' => 'ملغي',
            default => $this->status,
        };
    }

    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            'pending' => 'badge-warning text-dark',
            'contacted' => 'badge-info',
            'fulfilled' => 'badge-success',
            'cancelled' => 'badge-secondary',
            default => 'badge-light',
        };
    }

    public function getRequestTypeLabelAttribute()
    {
        return match ($this->request_type) {
            'rent' => 'إيجار',
            'sale' => 'شراء / تملك',
            default => $this->request_type,
        };
    }

    /**
     * تجهيز رقم الهاتف للواتساب بصيغة دولية (مثلاً لأرقام السعودية تحويل 05 إلى 9665)
     */
    public function getSanitizedPhoneAttribute()
    {
        $phone = preg_replace('/[^0-9]/', '', (string)$this->client_phone);
        if (str_starts_with($phone, '05')) {
            $phone = '966' . substr($phone, 1);
        } elseif (str_starts_with($phone, '5') && strlen($phone) === 9) {
            $phone = '966' . $phone;
        }
        return $phone;
    }

    /**
     * رابط واتساب المباشر مع رسالة جاهزة باسم العميل ومواصفات طلبه
     */
    public function getWhatsappUrlAttribute()
    {
        $phone = $this->sanitized_phone;
        if (empty($phone)) {
            return null;
        }

        $unitTypeName = $this->unitType ? $this->unitType->name : 'عقار';
        $location = trim(($this->city ? $this->city : '') . ' ' . ($this->district ? '- حي ' . $this->district : ''));

        $msg = "السلام عليكم ورحمة الله وبركاته، أستاذ {$this->client_name}.\n";
        $msg .= "بخصوص طلبك المسجل لدينا لـ ({$unitTypeName}) " . ($location ? "في {$location}" : "") . ".\n";
        $msg .= "يسرنا إبلاغك بتوفر خيارات مناسبة تطابق طلبك، نرجو التكرم بالتواصل معنا للمعاينة وإكمال الإجراءات.";

        return "https://wa.me/{$phone}?text=" . urlencode($msg);
    }

    // ==========================================================
    // محرك المطابقة الذكي (Smart Matching Engine)
    // ==========================================================

    /**
     * يبحث عن الوحدات الشاغرة المتوفرة التي تطابق مواصفات طلب العميل
     */
    public function findMatchingUnits($limit = 10)
    {
        // 1. استعلام الوحدات الشاغرة (is_rented = 0 و status = 1)
        $query = Unit::with('property')
            ->where('is_rented', 0)
            ->where(function ($q) {
                $q->where('status', '1')->orWhere('status', 'مفعل');
            });

        // نوع الوحدة / المبنى
        if ($this->unit_type_id) {
            $query->where(function ($q) {
                $q->where('unit_category', $this->unit_type_id)
                  ->orWhereHas('property', function ($pq) {
                      $pq->where('property_category', $this->unit_type_id);
                  });
            });
        }

        // نوع العرض (إيجار / بيع) من العقار
        if ($this->request_type) {
            $query->whereHas('property', function ($pq) {
                $pq->where('type', $this->request_type);
            });
        }

        // المدينة
        if ($this->city) {
            $query->whereHas('property', function ($pq) {
                $pq->where('city', 'like', '%' . trim($this->city) . '%');
            });
        }

        // الحي (تطابق تقريبي إن وجد)
        if ($this->district) {
            $query->whereHas('property', function ($pq) {
                $pq->where('district', 'like', '%' . trim($this->district) . '%');
            });
        }

        // الميزانية القصوى
        if ($this->max_price && $this->max_price > 0) {
            $query->where('annual_rent', '<=', (float)$this->max_price);
        }

        // الميزانية الدنيا
        if ($this->min_price && $this->min_price > 0) {
            $query->where('annual_rent', '>=', (float)$this->min_price);
        }

        // عدد الغرف (إذا كان محدداً)
        if ($this->rooms_count && $this->rooms_count > 0) {
            $query->where('rooms_count', '>=', (int)$this->rooms_count);
        }

        // عدد الحمامات
        if ($this->bathrooms_count && $this->bathrooms_count > 0) {
            $query->where('bathrooms_count', '>=', (int)$this->bathrooms_count);
        }

        // نوع التشطيب إن وجد
        if (!empty($this->finishing_type)) {
            $query->where('finishing_type', $this->finishing_type);
        }

        return $query->orderBy('annual_rent', 'asc')->limit($limit)->get();
    }

    /**
     * عدد الوحدات المتوفرة المطابقة حالياً
     */
    public function getMatchingUnitsCountAttribute()
    {
        return $this->findMatchingUnits(50)->count();
    }
}
