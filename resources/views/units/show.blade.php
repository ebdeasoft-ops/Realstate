@extends('layouts.master')

@section('title') 
{{ __('realestate.unit_details') }} 
@endsection

@section('css')
<style>
    .card-custom { border: none; border-radius: 12px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); }
    .section-title { font-size: 1.1rem; font-weight: 700; color: #4e73df; margin-bottom: 1.2rem; border-bottom: 2px solid #f8f9fc; padding-bottom: 8px; }
    .info-box { background: #f8f9fc; padding: 12px 15px; border-radius: 10px; margin-bottom: 15px; border-right: 4px solid #4e73df; transition: all 0.3s ease; }
    .info-box:hover { background: #f1f3f9; transform: translateY(-2px); }
    .info-label { font-size: 0.85rem; color: #858796; display: block; margin-bottom: 3px; font-weight: 600; }
    .info-value { font-size: 1rem; color: #2e59d9; font-weight: 700; }
    .badge-status { font-size: 0.85rem; padding: 6px 15px; border-radius: 50px; font-weight: 600; }
    .media-card { transition: 0.3s; border-radius: 10px; overflow: hidden; }
    .media-card:hover { transform: scale(1.03); box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- رأس الصفحة وأزرار التحكم -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="text-primary font-weight-bold mb-1">
                <i class="fas fa-door-open mr-2"></i> {{ __('realestate.unit_details') }}: <span class="text-dark">#{{ $unit->unit_number }}</span>
            </h4>
            <p class="text-muted mb-0">{{ __('realestate.units_management') }} / {{ $unit->property->name ?? '-' }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-primary px-4 shadow-sm">
                <i class="fas fa-edit mr-1"></i> {{ __('realestate.edit') ?? 'تعديل' }}
            </a>
            <a href="{{ route('units.index') }}" class="btn btn-secondary px-4 shadow-sm ml-2">
                <i class="fas fa-arrow-right mr-1"></i> {{ __('realestate.back') ?? 'رجوع' }}
            </a>
        </div>
    </div>

    <div class="card card-custom mb-4">
        <div class="card-body p-4">
            
            <!-- القسم الأول: المعلومات الأساسية والمالية -->
            <div class="section-title">
                <i class="fas fa-file-invoice-dollar mr-2"></i> {{ __('realestate.basic_info') ?? 'المعلومات الأساسية والمالية' }}
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-building mr-1 text-primary"></i> {{ __('realestate.properties') }}</span>
                        <span class="info-value text-dark">{{ $unit->property->name ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-money-bill-wave mr-1 text-success"></i> {{ __('realestate.annual_rent') }}</span>
                        <span class="info-value text-success">{{ number_format($unit->annual_rent, 2) }} {{ __('realestate.sar') }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box" style="border-right-color: {{ $unit->status == 1 || $unit->status == 'active' ? '#1cc88a' : '#e74a3b' }};">
                        <span class="info-label"><i class="fas fa-toggle-on mr-1 text-info"></i> {{ __('realestate.status') }}</span>
                        <span class="badge {{ $unit->status == 1 || $unit->status == 'active' ? 'badge-success' : 'badge-danger' }} badge-status">
                            {{ $unit->status == 1 || $unit->status == 'active' ? __('realestate.active') : __('realestate.inactive') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- القسم الثاني: خصائص الوحدة -->
            <div class="section-title mt-3">
                <i class="fas fa-list-ul mr-2"></i> {{ __('realestate.unit_specifications') ?? 'تفاصيل وخصائص الوحدة' }}
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-home mr-1 text-secondary"></i> {{ __('realestate.unit_type') }}</span>
                        <span class="info-value text-dark">{{ $unit->unit_category ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-paint-roller mr-1 text-secondary"></i> {{ __('realestate.finishing_type') }}</span>
                        <span class="info-value text-dark">{{ $unit->finishing_type ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-calendar-alt mr-1 text-secondary"></i> {{ __('realestate.payment_period') }}</span>
                        <span class="info-value text-dark">{{ $unit->payment_method ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- القسم الثالث: التقسيمات الداخلية والمرافق -->
            <div class="section-title mt-3">
                <i class="fas fa-th-large mr-2"></i> {{ __('realestate.rooms_and_utilities') ?? 'المرافق والتوزيع الداخلي' }}
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-layer-group mr-1 text-info"></i> {{ __('realestate.floor_number') }}</span>
                        <span class="info-value text-dark">{{ $unit->floor_number ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-bed mr-1 text-info"></i> {{ __('realestate.rooms_count') }}</span>
                        <span class="info-value text-dark">{{ $unit->rooms_count ?? '0' }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-utensils mr-1 text-info"></i> {{ __('realestate.kitchens_count') }}</span>
                        <span class="info-value text-dark">{{ $unit->kitchens_count ?? '0' }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-bath mr-1 text-info"></i> {{ __('realestate.bathrooms_count') }}</span>
                        <span class="info-value text-dark">{{ $unit->bathrooms_count ?? '0' }}</span>
                    </div>
                </div>
            </div>

            <!-- القسم الرابع: العدادات والتكييف -->
            <div class="row">
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-bolt mr-1 text-warning"></i> {{ __('realestate.electricity_meter') }}</span>
                        <span class="info-value text-dark">{{ $unit->electricity_meter ?? __('realestate.not_available') }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-tint mr-1 text-info"></i> {{ __('realestate.water_meter') }}</span>
                        <span class="info-value text-dark">{{ $unit->water_meter ?? __('realestate.not_available') }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-label"><i class="fas fa-snowflake mr-1 text-primary"></i> {{ __('realestate.ac_status') }}</span>
                        <span class="info-value text-dark">{{ $unit->ac_status ?? __('realestate.none') }}</span>
                    </div>
                </div>
            </div>

            <!-- المواصفات الإضافية / الملاحظات -->
            @if(!empty($unit->description))
            <div class="section-title mt-3">
                <i class="fas fa-clipboard-list mr-2"></i> {{ __('realestate.additional_specifications') }}
            </div>
            <div class="p-3 bg-light rounded shadow-sm text-secondary mb-3" style="border-right: 4px solid #6c757d;">
                {{ $unit->description }}
            </div>
            @endif

            <!-- قسم المرفقات والصور -->
            <div class="section-title mt-4">
                <i class="fas fa-images mr-2"></i> {{ __('realestate.unit_media') }}
            </div>
            <div class="row">
                @forelse($unit->images as $img)
                    <div class="col-md-3 mb-3">
                        <div class="media-card border shadow-sm bg-white p-1">
                            <a href="{{ asset('storage/' . $img->file_path) }}" target="_blank">
                                <img src="{{ asset('storage/' . $img->file_path) }}" class="img-fluid rounded w-100" style="height: 160px; object-fit: cover;">
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4 bg-light rounded text-muted">
                        <i class="fas fa-image fa-2x mb-2 d-block"></i>
                        <span>{{ __('realestate.no_media') ?? 'لا توجد مرفقات أو صور مضافة لهذه الوحدة' }}</span>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection