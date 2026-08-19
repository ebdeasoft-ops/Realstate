@extends('layouts.master')

@section('title')
{{ __('realestate.add_unit_new') ?? 'إضافة وحدة جديدة' }}
@endsection

@section('css')
<style>
.card-custom {
    border: none;
    border-radius: 12px;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.section-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #4e73df;
    margin-bottom: 1.2rem;
    border-bottom: 2px solid #f8f9fc;
    padding-bottom: 8px;
}

.form-group-custom {
    background: #f8f9fc;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
    border-right: 4px solid #4e73df;
    transition: all 0.3s ease;
}

.form-group-custom:hover {
    background: #f1f3f9;
}

.form-label {
    font-size: 0.85rem;
    color: #5a5c69;
    font-weight: 700;
    display: block;
    margin-bottom: 5px;
}

.form-control {
    border-radius: 8px;
    border: 1px solid #d1d3e2;
    padding: 10px 15px;
    height: auto;
}

.form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}

.btn-custom {
    border-radius: 8px;
    font-weight: 600;
    padding: 8px 20px;
}
</style>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between mb-4">
    <h4 class="content-title mb-0 text-primary font-weight-bold">
        <i class="fas fa-plus-circle mr-2"></i> {{ __('realestate.units_management') }}
    </h4>
</div>
@endsection

@section('content')
<div class="container-fluid py-2">
    @if ($errors->any())
    <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-4">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li><i class="fas fa-exclamation-circle mr-1"></i> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card card-custom mb-4">
        <div class="card-body p-4">
            <form action="{{ route('units.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf

                <!-- القسم الأول: العقار ورقم الوحدة -->
                <div class="section-title">
                    <i class="fas fa-building mr-2"></i>
                    {{ __('realestate.basic_info') ?? 'المعلومات الرئيسية والعقار' }}
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label class="form-label"><i class="fas fa-city mr-1 text-primary"></i>
                                {{ __('realestate.select_property') }} <span class="text-danger">*</span></label>
                            <select name="property_id" class="form-control" required>
                                <option value="">{{ __('realestate.select_property_placeholder') }}</option>
                                @foreach($properties as $property)
                                <option value="{{ $property->id }}"
                                    {{ old('property_id') == $property->id ? 'selected' : '' }}>
                                    {{ $property->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label class="form-label"><i class="fas fa-door-open mr-1 text-primary"></i>
                                {{ __('realestate.unit_number') }} <span class="text-danger">*</span></label>
                            <input type="text" name="unit_number" class="form-control"
                                value="{{ old('unit_number', '1') }}" required>
                        </div>
                    </div>
                </div>

                <!-- القسم الثاني: المعلومات المالية ونوع الوحدة -->
                <div class="section-title mt-3">
                    <i class="fas fa-file-invoice-dollar mr-2"></i>
                    {{ __('realestate.financial_details') ?? 'الخصائص والبيانات المالية' }}
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group-custom">
                            <label class="form-label"><i class="fas fa-home mr-1 text-secondary"></i>
                                {{ __('realestate.unit_type') }}</label>
                            <select name="unit_type_id" class="form-control select2">
                                <option value="" disabled selected>{{ __('realestate.choose_unit_type') }}</option>
                                @foreach(\App\Models\UnitType::all() as $type)
                                <option value="{{ $type->id }}"
                                    {{ old('unit_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group-custom">
                            <label class="form-label"><i class="fas fa-paint-roller mr-1 text-secondary"></i>
                                {{ __('realestate.finishing_type') }}</label>
                            <select name="finishing_type" class="form-control">
                                @foreach(__('realestate.finishing_types_list') as $key => $value)
                                <option value="{{ $value }}" {{ old('finishing_type') == $value ? 'selected' : '' }}>
                                    {{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group-custom">
                            <label class="form-label"><i class="fas fa-calendar-alt mr-1 text-secondary"></i>
                                {{ __('realestate.payment_period') }}</label>
                            <select name="payment_method" class="form-control">
                                @foreach(__('realestate.payment_period_options') as $key => $value)
                                <option value="{{ $value }}" {{ old('payment_method') == $value ? 'selected' : '' }}>
                                    {{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-custom">
                            <label class="form-label"><i class="fas fa-money-bill-wave mr-1 text-success"></i>
                                {{ __('realestate.annual_rent') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="annual_rent" class="form-control"
                                    value="{{ old('annual_rent') }}" placeholder="0.00" required>
                                <div class="input-group-append"><span
                                        class="input-group-text bg-light font-weight-bold">{{ __('realestate.sar') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-custom" style="border-right-color: #1cc88a;">
                            <label class="form-label"><i class="fas fa-toggle-on mr-1 text-success"></i>
                                {{ __('realestate.status') }} <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="">{{ __('realestate.choose_status') ?? 'اختر الحالة...' }}</option>
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>
                                    {{ __('realestate.active') }}</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                                    {{ __('realestate.inactive') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- القسم الثالث: التقسيمات الداخلية والمرافق -->
                <div class="section-title mt-3">
                    <i class="fas fa-th-large mr-2"></i>
                    {{ __('realestate.rooms_and_utilities') ?? 'التقسيمات الداخلية والمرافق' }}
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group-custom">
                            <label class="form-label"><i class="fas fa-layer-group mr-1 text-info"></i>
                                {{ __('realestate.floor_number') }}</label>
                            <input type="text" name="floor_number" class="form-control"
                                value="{{ old('floor_number') }}"
                                placeholder="{{ __('realestate.floor_placeholder') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group-custom">
                            <label class="form-label"><i class="fas fa-bed mr-1 text-info"></i>
                                {{ __('realestate.rooms_count') }}</label>
                            <input type="number" name="rooms_count" class="form-control"
                                value="{{ old('rooms_count') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group-custom">
                            <label class="form-label"><i class="fas fa-utensils mr-1 text-info"></i>
                                {{ __('realestate.kitchens_count') }}</label>
                            <input type="number" name="kitchens_count" class="form-control"
                                value="{{ old('kitchens_count') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group-custom">
                            <label class="form-label"><i class="fas fa-bath mr-1 text-info"></i>
                                {{ __('realestate.bathrooms_count') }}</label>
                            <input type="number" name="bathrooms_count" class="form-control"
                                value="{{ old('bathrooms_count') }}">
                        </div>
                    </div>
                </div>

                <!-- القسم الرابع: العدادات والتكييف والملاحظات والمرفقات -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group-custom" style="border-right-color: #f6c23e;">
                            <label class="form-label"><i class="fas fa-bolt mr-1 text-warning"></i>
                                {{ __('realestate.electricity_meter') }}</label>
                            <input type="text" name="electricity_meter" class="form-control"
                                value="{{ old('electricity_meter') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group-custom" style="border-right-color: #36b9cc;">
                            <label class="form-label"><i class="fas fa-tint mr-1 text-info"></i>
                                {{ __('realestate.water_meter') }}</label>
                            <input type="text" name="water_meter" class="form-control" value="{{ old('water_meter') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group-custom" style="border-right-color: #4e73df;">
                            <label class="form-label"><i class="fas fa-fan mr-1 text-primary"></i>
                                {{ __('realestate.ac_count') }}</label>
                            <input type="number" name="ac_count" class="form-control" value="{{ old('ac_count') }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group-custom" style="border-right-color: #4e73df;">
                            <label class="form-label"><i class="fas fa-snowflake mr-1 text-primary"></i>
                                {{ __('realestate.ac_status') }}</label>
                            <select name="ac_status" class="form-control">
                                @foreach(__('realestate.ac_options') as $key => $value)
                                <option value="{{ $value }}" {{ old('ac_status') == $value ? 'selected' : '' }}>
                                    {{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group-custom" style="border-right-color: #6c757d;">
                            <label class="form-label"><i class="fas fa-clipboard-list mr-1 text-secondary"></i>
                                {{ __('realestate.additional_specifications') }}</label>
                            <textarea name="description" class="form-control" rows="3"
                                placeholder="{{ __('realestate.notes_placeholder') }}">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- قسم المرفقات -->
                <div class="form-group-custom mt-2" style="border-right-color: #e74a3b;">
                    <label class="form-label"><i class="fas fa-cloud-upload-alt mr-1 text-danger"></i>
                        {{ __('realestate.unit_images') }} <small
                            class="text-muted">({{ __('realestate.multiple_images_note') }})</small></label>
                    <input type="file" name="media[]" class="form-control-file border p-2 rounded w-100 bg-white"
                        multiple accept="image/*,video/*">
                </div>

                <!-- أزرار الحفظ والرجوع -->
                <div class="text-center mt-5 pt-2 border-top">
                    <button type="submit" class="btn btn-success btn-custom px-5 shadow-sm">
                        <i class="fas fa-check mr-1"></i> {{ __('realestate.confirm_add_unit') ?? 'حفظ وإنشاء الوحدة' }}
                    </button>
                    <a href="{{ route('units.index') }}" class="btn btn-secondary btn-custom px-4 shadow-sm ml-2">
                        <i class="fas fa-arrow-right mr-1"></i> {{ __('realestate.back') ?? 'رجوع' }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection