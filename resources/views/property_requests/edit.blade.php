@extends('layouts.master')

@section('title')
{{ __('realestate.edit_property_request') }} #{{ $propertyRequest->id }}
@endsection

@section('css')
<style>
    .form-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .form-section-header {
        display: flex;
        align-items: center;
        padding-bottom: 10px;
        margin-bottom: 20px;
        border-bottom: 1px solid #e9edf4;
    }
    .form-section-header i {
        font-size: 1.1rem;
        color: #0162e8;
        margin-left: 8px;
        margin-right: 8px;
    }
    .form-section-header h6 {
        font-size: 0.95rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 0;
    }
    .form-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: #475569;
        margin-bottom: 6px;
    }
    .form-control, .custom-select {
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        font-size: 0.875rem;
        height: 42px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .form-control:focus, .custom-select:focus {
        border-color: #0162e8;
        box-shadow: 0 0 0 0.2rem rgba(1, 98, 232, 0.15);
    }
    textarea.form-control {
        height: auto;
    }
    .input-group-text {
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        background-color: #f8fafc;
        color: #64748b;
    }
    .btn-submit {
        background-color: #0162e8;
        border-color: #0162e8;
        color: #fff;
        padding: 10px 32px;
        font-weight: 600;
        border-radius: 6px;
    }
    .btn-submit:hover {
        background-color: #0153c5;
        color: #fff;
    }
    .status-alert-box {
        background-color: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between mb-3">
    <div>
        <h4 class="content-title mb-1 text-primary font-weight-bold">
            <i class="fas fa-edit mr-2"></i> {{ __('realestate.edit_property_request') }} #{{ $propertyRequest->id }}
        </h4>
        <p class="text-muted mb-0 font-13">{{ $propertyRequest->client_name }} - {{ $propertyRequest->client_phone }}</p>
    </div>
    <div>
        <a href="{{ route('property-requests.show', $propertyRequest->id) }}" class="btn btn-outline-info btn-sm shadow-sm mr-1" style="border-radius: 6px; padding: 7px 18px;">
            <i class="fas fa-eye mr-1"></i> {{ __('realestate.request_details') }}
        </a>
        <a href="{{ route('property-requests.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm" style="border-radius: 6px; padding: 7px 18px;">
            <i class="fas fa-arrow-right mr-1"></i> {{ __('realestate.back') }}
        </a>
    </div>
</div>
@endsection

@section('content')

@if (isset($errors) && $errors->any())
<div class="alert alert-danger border-0 shadow-sm rounded-lg mb-4">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li><i class="fas fa-exclamation-circle mr-1"></i> {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('property-requests.update', $propertyRequest->id) }}" method="POST" autocomplete="off">
    @csrf
    @method('PUT')

    <!-- كارت حالة الطلب -->
    <div class="card form-card mb-4">
        <div class="card-body p-4">
            <div class="status-alert-box">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-2 mb-md-0">
                        <label class="form-label text-success font-weight-bold mb-1">
                            <i class="fas fa-toggle-on mr-1"></i> {{ __('realestate.request_status') }}
                        </label>
                        <select name="status" class="form-control" required>
                            <option value="pending" {{ old('status', $propertyRequest->status) == 'pending' ? 'selected' : '' }}>{{ __('realestate.status_pending') }}</option>
                            <option value="contacted" {{ old('status', $propertyRequest->status) == 'contacted' ? 'selected' : '' }}>{{ __('realestate.status_contacted') }}</option>
                            <option value="fulfilled" {{ old('status', $propertyRequest->status) == 'fulfilled' ? 'selected' : '' }}>{{ __('realestate.status_fulfilled') }}</option>
                            <option value="cancelled" {{ old('status', $propertyRequest->status) == 'cancelled' ? 'selected' : '' }}>{{ __('realestate.status_cancelled') }}</option>
                        </select>
                    </div>
                    <div class="col-md-6 font-13 text-muted">
                        <i class="fas fa-info-circle mr-1"></i>
                        {{ __('realestate.change_status') }}
                    </div>
                </div>
            </div>

            <!-- بيانات العميل -->
            <div class="form-section-header">
                <i class="fas fa-user-circle"></i>
                <h6>{{ __('realestate.client_info') }}</h6>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('realestate.client_name') }} <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="client_name" class="form-control" value="{{ old('client_name', $propertyRequest->client_name) }}" required>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('realestate.client_phone') }} <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" name="client_phone" class="form-control" value="{{ old('client_phone', $propertyRequest->client_phone) }}" required>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('realestate.national_id_or_iqama') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input type="text" name="national_id" class="form-control" value="{{ old('national_id', $propertyRequest->national_id) }}">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('realestate.email_address') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="email" name="client_email" class="form-control" value="{{ old('client_email', $propertyRequest->client_email) }}">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- كارت نوع العقار والموقع والميزانية -->
    <div class="card form-card mb-4">
        <div class="card-body p-4">
            <div class="form-section-header">
                <i class="fas fa-home"></i>
                <h6>{{ __('realestate.property_and_purpose') }}</h6>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('realestate.request_purpose') }} <span class="text-danger">*</span></label>
                    <select name="request_type" class="form-control" required>
                        <option value="rent" {{ old('request_type', $propertyRequest->request_type) == 'rent' ? 'selected' : '' }}>{{ __('realestate.for_rent') }}</option>
                        <option value="sale" {{ old('request_type', $propertyRequest->request_type) == 'sale' ? 'selected' : '' }}>{{ __('realestate.for_sale') }}</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('realestate.unit_type_required') }}</label>
                    <select name="unit_type_id" class="form-control select2">
                        <option value="">{{ __('realestate.any_unit_type') }}</option>
                        @foreach($unitTypes as $type)
                        <option value="{{ $type->id }}" {{ old('unit_type_id', $propertyRequest->unit_type_id) == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-section-header mt-3">
                <i class="fas fa-map-marker-alt"></i>
                <h6>{{ __('realestate.location_and_budget') }}</h6>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('realestate.target_city') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-city"></i></span>
                        </div>
                        <input type="text" name="city" list="cities_list" class="form-control" value="{{ old('city', $propertyRequest->city) }}">
                        <datalist id="cities_list">
                            @foreach($cities as $c)
                            <option value="{{ $c }}">
                            @endforeach
                        </datalist>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('realestate.target_district') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                        </div>
                        <input type="text" name="district" class="form-control" value="{{ old('district', $propertyRequest->district) }}">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('realestate.min_budget') }}</label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="min_price" class="form-control" value="{{ old('min_price', $propertyRequest->min_price) }}">
                        <div class="input-group-append">
                            <span class="input-group-text">{{ __('realestate.sar') }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('realestate.max_budget') }}</label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="max_price" class="form-control" value="{{ old('max_price', $propertyRequest->max_price) }}">
                        <div class="input-group-append">
                            <span class="input-group-text">{{ __('realestate.sar') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- كارت المواصفات والملاحظات -->
    <div class="card form-card mb-4">
        <div class="card-body p-4">
            <div class="form-section-header">
                <i class="fas fa-sliders-h"></i>
                <h6>{{ __('realestate.specifications_and_amenities') }}</h6>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ __('realestate.requested_rooms') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-bed"></i></span>
                        </div>
                        <input type="number" name="rooms_count" class="form-control" value="{{ old('rooms_count', $propertyRequest->rooms_count) }}">
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ __('realestate.requested_bathrooms') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-bath"></i></span>
                        </div>
                        <input type="number" name="bathrooms_count" class="form-control" value="{{ old('bathrooms_count', $propertyRequest->bathrooms_count) }}">
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ __('realestate.preferred_floor') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                        </div>
                        <input type="text" name="floor_number" class="form-control" value="{{ old('floor_number', $propertyRequest->floor_number) }}">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('realestate.preferred_finishing') }}</label>
                    <select name="finishing_type" class="form-control">
                        <option value="">{{ __('realestate.any_finishing') }}</option>
                        @php
                            $finishingList = is_array(__('realestate.finishing_types_list')) ? __('realestate.finishing_types_list') : ['سوبر ديلوكس', 'ديلوكس', 'تشطيب كامل', 'نصف تشطيب', 'عظم'];
                        @endphp
                        @foreach($finishingList as $val)
                        <option value="{{ $val }}" {{ old('finishing_type', $propertyRequest->finishing_type) == $val ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('realestate.preferred_ac') }}</label>
                    <select name="ac_status" class="form-control">
                        <option value="">{{ __('realestate.any_ac') }}</option>
                        @php
                            $acList = is_array(__('realestate.ac_options')) ? __('realestate.ac_options') : ['راكب', 'غير راكب', 'مركزي', 'سبليت'];
                        @endphp
                        @foreach($acList as $ac)
                        <option value="{{ $ac }}" {{ old('ac_status', $propertyRequest->ac_status) == $ac ? 'selected' : '' }}>{{ $ac }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">{{ __('realestate.client_notes') }}</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $propertyRequest->notes) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- زر الحفظ والإلغاء -->
    <div class="d-flex justify-content-end mb-5">
        <a href="{{ route('property-requests.show', $propertyRequest->id) }}" class="btn btn-secondary mr-2" style="border-radius: 6px; padding: 10px 24px;">
            {{ __('realestate.cancel') }}
        </a>
        <button type="submit" class="btn btn-submit shadow-sm">
            <i class="fas fa-save mr-1"></i> {{ __('realestate.save_changes') }}
        </button>
    </div>
</form>

@endsection
