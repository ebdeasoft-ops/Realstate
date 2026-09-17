@extends('layouts.master')

@section('title')
{{ __('realestate.add_property_request') }}
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
    .customer-lookup-box {
        background-color: #f8fafc;
        border: 1px dashed #cbd5e1;
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
            <i class="fas fa-plus-circle mr-2"></i> {{ __('realestate.add_property_request') }}
        </h4>
        <p class="text-muted mb-0 font-13">{{ __('realestate.property_requests_subtitle') }}</p>
    </div>
    <div>
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

<form action="{{ route('property-requests.store') }}" method="POST" autocomplete="off">
    @csrf

    <!-- كارت بيانات العميل -->
    <div class="card form-card mb-4">
        <div class="card-body p-4">
            <div class="form-section-header">
                <i class="fas fa-user-circle"></i>
                <h6>{{ __('realestate.client_info') }}</h6>
            </div>

            <!-- اختيار عميل موجود -->
            <div class="customer-lookup-box">
                <div class="form-group mb-0">
                    <label class="form-label text-primary">
                        <i class="fas fa-search mr-1"></i> {{ __('realestate.select_existing_customer') }}
                    </label>
                    <select name="customer_id" id="customer_select" class="form-control select2">
                        <option value="">{{ __('realestate.unregistered_client') }}</option>
                        @foreach($customers as $c)
                        <option value="{{ $c->id }}"
                            data-name="{{ $c->name }}"
                            data-phone="{{ $c->phone }}"
                            data-email="{{ $c->email }}"
                            data-idnumber="{{ $c->id_number }}"
                            {{ old('customer_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->name }} {{ $c->phone ? "({$c->phone})" : '' }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('realestate.client_name') }} <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="client_name" id="client_name" class="form-control" value="{{ old('client_name') }}" placeholder="{{ __('realestate.client_name_placeholder') }}" required>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('realestate.client_phone') }} <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" name="client_phone" id="client_phone" class="form-control" value="{{ old('client_phone') }}" placeholder="{{ __('realestate.client_phone_placeholder') }}" required>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('realestate.national_id_or_iqama') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input type="text" name="national_id" id="national_id" class="form-control" value="{{ old('national_id') }}" placeholder="{{ __('realestate.national_id_placeholder') }}">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('realestate.email_address') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="email" name="client_email" id="client_email" class="form-control" value="{{ old('client_email') }}" placeholder="{{ __('realestate.email_placeholder') }}">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="save_as_new_customer" value="1" class="custom-control-input" id="save_as_new_customer" {{ old('save_as_new_customer') ? 'checked' : '' }}>
                        <label class="custom-control-label font-weight-normal text-muted font-13" for="save_as_new_customer">
                            {{ __('realestate.save_as_new_customer') }}
                        </label>
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
                        <option value="rent" {{ old('request_type', 'rent') == 'rent' ? 'selected' : '' }}>{{ __('realestate.for_rent') }}</option>
                        <option value="sale" {{ old('request_type') == 'sale' ? 'selected' : '' }}>{{ __('realestate.for_sale') }}</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('realestate.unit_type_required') }}</label>
                    <select name="unit_type_id" class="form-control select2">
                        <option value="">{{ __('realestate.any_unit_type') }}</option>
                        @foreach($unitTypes as $type)
                        <option value="{{ $type->id }}" {{ old('unit_type_id') == $type->id ? 'selected' : '' }}>
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
                        <input type="text" name="city" list="cities_list" class="form-control" value="{{ old('city') }}" placeholder="{{ __('realestate.city_placeholder') }}">
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
                        <input type="text" name="district" class="form-control" value="{{ old('district') }}" placeholder="{{ __('realestate.district_placeholder') }}">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('realestate.min_budget') }}</label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="min_price" class="form-control" value="{{ old('min_price') }}" placeholder="0.00">
                        <div class="input-group-append">
                            <span class="input-group-text">{{ __('realestate.sar') }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('realestate.max_budget') }}</label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="max_price" class="form-control" value="{{ old('max_price') }}" placeholder="0.00">
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
                        <input type="number" name="rooms_count" class="form-control" value="{{ old('rooms_count') }}" placeholder="{{ __('realestate.rooms_placeholder') }}">
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ __('realestate.requested_bathrooms') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-bath"></i></span>
                        </div>
                        <input type="number" name="bathrooms_count" class="form-control" value="{{ old('bathrooms_count') }}" placeholder="{{ __('realestate.bathrooms_placeholder') }}">
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ __('realestate.preferred_floor') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                        </div>
                        <input type="text" name="floor_number" class="form-control" value="{{ old('floor_number') }}" placeholder="{{ __('realestate.floor_placeholder') }}">
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
                        <option value="{{ $val }}" {{ old('finishing_type') == $val ? 'selected' : '' }}>{{ $val }}</option>
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
                        <option value="{{ $ac }}" {{ old('ac_status') == $ac ? 'selected' : '' }}>{{ $ac }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">{{ __('realestate.client_notes') }}</label>
                    <textarea name="notes" class="form-control" rows="3" placeholder="{{ __('realestate.notes_placeholder_text') }}">{{ old('notes') }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- زر الحفظ والإلغاء -->
    <div class="d-flex justify-content-end mb-5">
        <a href="{{ route('property-requests.index') }}" class="btn btn-secondary mr-2" style="border-radius: 6px; padding: 10px 24px;">
            {{ __('realestate.cancel') }}
        </a>
        <button type="submit" class="btn btn-submit shadow-sm">
            <i class="fas fa-check-circle mr-1"></i> {{ __('realestate.save') }}
        </button>
    </div>
</form>

@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const customerSelect = document.getElementById('customer_select');
        const nameInput = document.getElementById('client_name');
        const phoneInput = document.getElementById('client_phone');
        const emailInput = document.getElementById('client_email');
        const idInput = document.getElementById('national_id');

        if (customerSelect) {
            customerSelect.addEventListener('change', function() {
                const opt = this.options[this.selectedIndex];
                if (opt && opt.value) {
                    nameInput.value = opt.getAttribute('data-name') || '';
                    phoneInput.value = opt.getAttribute('data-phone') || '';
                    emailInput.value = opt.getAttribute('data-email') || '';
                    idInput.value = opt.getAttribute('data-idnumber') || '';
                }
            });
        }
    });
</script>
@endsection
