@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <style>
        .property-header-card { background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-right: 4px solid #0162e8; }
        .unit-card { transition: all 0.3s ease; border-radius: 12px; border: 1px solid rgba(0,0,0,0.05); }
        .unit-card:hover { transform: translateY(-3px); box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important; }
        .info-pill { background: rgba(1, 98, 232, 0.05); padding: 6px 12px; border-radius: 6px; font-size: 13px; }
    </style>
@endsection

@section('title')
    {{ __('realestate.property_control_units') ?? 'التحكم بالعقارات والوحدات' }}
@stop

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto font-weight-bold">
                    <i class="fas fa-tachometer-alt text-primary ml-2"></i> {{ __('realestate.property_control') ?? 'لوحة تحكم العقار' }}
                </h4>
            </div>
        </div>
    </div>
@endsection

@section('content')

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle ml-2"></i> <strong>{{ session()->get('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- شريط اختيار العقار العلوي --}}
    <div class="card shadow-sm border-0 mb-4 p-3" style="border-radius: 12px;">
        <div class="row align-items-center">
            <div class="col-md-7 d-flex align-items-center mb-2 mb-md-0">
                <label for="property_select" class="font-weight-bold ml-3 mb-0 text-nowrap text-muted"><i class="fas fa-building text-primary ml-1"></i> {{ __('realestate.select_property') ?? 'اختر العقار' }} :</label>
                <select id="property_select" class="form-control select2" onchange="if (this.value) window.location.href=this.value;">
                    <option value="" disabled selected>{{ $property->name ?? __('realestate.select_current_property') }}</option>
                    @foreach($allProperties as $prop)
                        <option value="{{ route('properties.control', $prop->id) }}" {{ $property->id == $prop->id ? 'selected' : '' }}>
                            {{ $prop->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5 text-md-left">
                <span class="badge badge-primary px-3 py-2" style="font-size: 13px; border-radius: 20px;">
                    <i class="fas fa-home ml-1"></i> {{ __('realestate.current_property') ?? 'العقار الحالي' }}: <strong>{{ $property->name }}</strong>
                </span>
            </div>
        </div>
    </div>

    {{-- بطاقة تفاصيل العقار والعمليات --}}
    <div class="card property-header-card shadow-sm border-0 mb-4 p-4" style="border-radius: 12px;">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-3 mb-lg-0">
                <h5 class="text-dark font-weight-bold mb-3">
                    <i class="fas fa-info-circle text-primary ml-1"></i> بيانات العقار الأساسية
                </h5>
                <div class="d-flex flex-wrap" style="gap: 15px; font-size: 14px;">
                    <div class="info-pill">
                        <i class="fas fa-user-tie text-primary ml-1"></i> <strong>{{ __('realestate.owner_name') ?? 'المالك' }}:</strong> {{ optional($property->owner)->name ?? $property->owner_name ?? __('realestate.not_available') }}
                    </div>
                    <div class="info-pill">
                        <i class="fas fa-phone text-success ml-1"></i> <strong>{{ __('realestate.phone') ?? 'هاتف' }}:</strong> {{ optional($property->owner)->phone ?? $property->owner_phone ?? __('realestate.not_available') }}
                    </div>
                    <div class="info-pill">
                        <i class="fas fa-map-marker-alt text-danger ml-1"></i> <strong>{{ __('realestate.address') ?? 'العنوان' }}:</strong> {{ $property->address ?? __('realestate.not_available') }}
                    </div>
                </div>
            </div>

            <div class="col-lg-5 text-lg-left">
                <div class="d-flex flex-wrap justify-content-lg-end" style="gap: 6px;">
                    <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-outline-primary btn-sm px-3 shadow-sm"><i class="fas fa-edit ml-1"></i> تعديل العقار</a>
                    <a href="{{ route('units.create', ['property_id' => $property->id]) }}" class="btn btn-success btn-sm px-3 shadow-sm"><i class="fas fa-plus-circle ml-1"></i> إضافة وحدة</a>
                    <form action="{{ route('properties.destroy', $property->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا العقار بالكامل؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm px-3 shadow-sm"><i class="fas fa-trash-alt ml-1"></i> حذف</button>
                    </form>
                </div>
                <div class="d-flex flex-wrap justify-content-lg-end mt-2" style="gap: 6px;">
                    <a href="#" class="btn btn-light btn-sm text-info border"><i class="fas fa-chart-line ml-1"></i> الإيرادات</a>
                    <a href="#" class="btn btn-light btn-sm text-warning border"><i class="fas fa-tools ml-1"></i> المصاريف</a>
                    <a href="#" class="btn btn-light btn-sm text-secondary border"><i class="fas fa-file-invoice-dollar ml-1"></i> الصافي</a>
                </div>
            </div>
        </div>
    </div>

    {{-- قسم صور العقار --}}
    <div class="card shadow-sm border-0 mb-4 p-3" style="border-radius: 12px;">
        <h5 class="font-weight-bold mb-3"><i class="fas fa-images text-primary ml-1"></i> معرض صور العقار</h5>
        <div class="row">
            @forelse($property->images ?? [] as $image)
                <div class="col-md-2 col-sm-4 mb-2">
                    <a href="{{ asset($image->path) }}" target="_blank">
                        <img src="{{ asset($image->path) }}" class="img-thumbnail" style="height: 100px; width: 100%; object-fit: cover; border-radius: 8px;">
                    </a>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-3">
                    <i class="fas fa-camera-slash mb-2"></i> لا توجد صور مضافة لهذا العقار.
                </div>
            @endforelse
        </div>
        <div class="mt-2 text-left">
            <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-plus ml-1"></i> إدارة وإضافة صور العقار
            </a>
        </div>
    </div>

    {{-- عنوان قائمة الوحدات --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="content-title font-weight-bold mb-0" style="font-size: 18px;">
            <i class="fas fa-th-list text-primary ml-1"></i> وحدات العقار والوضع الحالي
        </h4>
        <span class="text-muted font-weight-bold" style="font-size: 13px;">إجمالي الوحدات: {{ $property->units->count() }}</span>
    </div>

    {{-- قائمة وحدات العقار الاحترافية --}}
    <div class="row">
        @forelse($property->units as $unit)
            <div class="col-lg-12 mb-3">
                @php
                    $isRented = $unit->is_rented == 1;
                    // جلب العقد النشط مع بيانات المستأجر المرتبطة به (تأكد أن علاقة activeContract أو tenant موجودة في موديل Unit)
                    $activeContract = $isRented ? $unit->activeContract()->with('tenant')->first() : null;
                @endphp
                <div class="card unit-card shadow-sm mb-0" style="border-right: 5px solid {{ $isRented ? '#dc3545' : '#28a745' }};">
                    <div class="card-body py-3">
                        <div class="row align-items-center">
                            
                            {{-- تفاصيل الوحدة --}}
                            <div class="col-md-4 border-left">
                                <div class="d-flex align-items-center mb-2">
                                    <h5 class="text-dark font-weight-bold mb-0">
                                        <i class="fas fa-door-open text-primary ml-1"></i> {{ $unit->unit_name ?? 'وحدة رقم ' . $unit->unit_number }}
                                    </h5>
                                </div>
                                <div class="text-muted d-flex flex-wrap" style="gap: 10px; font-size: 12px;">
                                    <span><i class="fas fa-building ml-1"></i> الدور: {{ $unit->floor_number ?? 'الأرضي' }}</span>
                                    <span><i class="fas fa-bed ml-1"></i> غرف: {{ $unit->rooms_count ?? 0 }}</span>
                                    <span><i class="fas fa-bath ml-1"></i> حمامات: {{ $unit->bathrooms_count ?? 0 }}</span>
                                </div>
                                <div class="mt-2 font-weight-bold text-success" style="font-size: 13px;">
                                    الإيجار السنوي: {{ number_format($unit->annual_rent, 2) }} ريال
                                </div>
                            </div>

                            {{-- تفاصيل المستأجر الحالي أو حالة الشغور --}}
                            <div class="col-md-5 border-left my-2 my-md-0">
                                @if($isRented)
                                    <div class="p-2 bg-light rounded border-right border-danger border-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="text-danger font-weight-bold" style="font-size: 13px;">
                                                <i class="fas fa-user-check ml-1"></i> المستأجر: 
                                                <span class="text-dark">
                                                    {{ optional(optional($activeContract)->tenant)->name ?? 'غير محدد' }}
                                                </span>
                                            </span>
                                            <span class="badge badge-danger" style="font-size: 11px;">مؤجرة</span>
                                        </div>
                                        <div class="text-muted" style="font-size: 12px; line-height: 1.5;">
                                            <div><i class="fas fa-phone ml-1 text-success"></i> الهاتف: {{ optional(optional($activeContract)->tenant)->phone ?? 'غير متوفر' }}</div>
                                            <div><i class="fas fa-info-circle ml-1 text-info"></i> الوصف: {{ $unit->description ?? 'لا يوجد وصف' }}</div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-2">
                                        <span class="badge badge-success px-3 py-2 mb-2" style="font-size: 12px;">
                                            <i class="fas fa-check-circle ml-1"></i> الوحدة شاغرة وجاهزة للتأجير
                                        </span>
                                        <br>
                                        <a href="{{ route('lease_contracts.create', ['unit_id' => $unit->id]) }}" class="btn btn-success btn-xs px-3 shadow-sm" style="font-size: 12px;">
                                            <i class="fas fa-file-contract ml-1"></i> تأجير الآن
                                        </a>
                                    </div>
                                @endif
                            </div>

                            {{-- إجراءات الوحدة --}}
                            <div class="col-md-3 text-center">
                                <div class="d-flex justify-content-center flex-wrap" style="gap: 5px;">
                                    <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-outline-primary btn-sm px-2" title="تعديل الوحدة">
                                        <i class="fas fa-edit"></i> تعديل
                                    </a>

                                    <a href="{{ route('units.show', $unit->id) }}" class="btn btn-outline-info btn-sm px-2" title="عرض الصور والمرفقات">
                                        <i class="fas fa-images"></i> صور
                                    </a>

                                    @if($isRented)
                                        <form action="#" method="POST" class="d-inline" onsubmit="return confirm('هل تريد إخلاء هذه الوحدة؟');">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-warning btn-sm px-2" title="إخلاء">
                                                <i class="fas fa-sign-out-alt"></i> إخلاء
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('units.destroy', $unit->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الوحدة؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm px-2" title="حذف">
                                            <i class="fas fa-trash"></i> حذف
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center p-4 shadow-sm" style="border-radius: 10px;">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2 text-warning"></i>
                    <p class="mb-0 font-weight-bold">لا توجد وحدات مسجلة لهذا العقار حتى الآن. يمكنك النقر على زر "إضافة وحدة" بالأعلى لبدء إضافة الوحدات.</p>
                </div>
            </div>
        @endforelse
    </div>

@endsection

@section('js')
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({ width: '100%' });
        });
    </script>
@endsection