@extends('layouts.master')

@section('css')
<style>
    .card-header-custom { background: #f8f9fa; border-bottom: 1px solid #eee; padding: 20px; display: flex; justify-content: space-between; align-items: center; }
    .btn-custom { border-radius: 8px; font-weight: 600; padding: 8px 20px; }
    .form-label { font-weight: bold; color: #333; }
</style>
@endsection

@section('title') {{ __('realestate.add_property') }} @endsection

@section('content')
@if ($errors->any())
    <div class="alert alert-danger mx-4 mt-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card shadow-sm border-0">
            <div class="card-header-custom">
                <h5 class="mb-0 text-primary"><i class="fas fa-building mr-2"></i> {{ __('realestate.add_property') }}</h5>
                <a href="{{ route('properties.index') }}" class="btn btn-secondary btn-custom">
                    <i class="fas fa-arrow-right"></i> {{ __('realestate.back') }}
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    
                    <div class="row">
                        <!-- القسم الأيمن: بيانات العقار والمالك الأساسية -->
                        <div class="col-md-6 border-left">
                            <h6 class="text-primary font-weight-bold mb-3"><i class="fas fa-home ml-1"></i> {{ __('realestate.property_details') }}</h6>
                            
                            <!-- قائمة نوع العقار -->
                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.unit_type') }} :</label>
                                <select name="property_category" class="form-control" required>
                                    <option value="" disabled selected>{{ __('realestate.choose_unit_type') }}</option>
                                    @foreach(__('realestate.unit_types_list') as $key => $label)
                                        <option value="{{ $key }}" {{ old('property_category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.owner_name') }} :</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            </div>

                            <!-- خانة الحالة -->
                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.status') ?? 'الحالة' }} :</label>
                                <select name="status" class="form-control" required>
                                    <option value="" disabled selected>{{ __('realestate.choose_status') ?? 'اختر الحالة...' }}</option>
                                    <option value="مفعل" {{ old('status') == 'مفعل' ? 'selected' : '' }}>{{ __('realestate.active') ?? 'مفعل' }}</option>
                                    <option value="غير مفعل" {{ old('status') == 'غير مفعل' ? 'selected' : '' }}>{{ __('realestate.inactive') ?? 'غير مفعل' }}</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.address') }} :</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                            </div>

                            <!-- حقل المدينة المضاف حديثاً مع الترجمة -->
                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.city') ?? 'المدينة' }} :</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
                            </div>

                            <!-- حقل الحي المضاف حديثاً مع الترجمة -->
                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.district') ?? 'الحي' }} :</label>
                                <input type="text" name="district" class="form-control" value="{{ old('district') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.owner_name') }} :</label>
                                <select name="owner_id" class="form-control" required>
                                    <option value="" disabled selected>{{ __('realestate.choose_property') }}</option>
                                    @foreach($owners as $owner)
                                        <option value="{{ $owner->id }}" {{ old('owner_id') == $owner->id ? 'selected' : '' }}>{{ $owner->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.owner_id_number') }} :</label>
                                <input type="text" name="owner_id_number" class="form-control" value="{{ old('owner_id_number') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.owner_nationality') }} :</label>
                                <input type="text" name="owner_nationality" class="form-control" value="{{ old('owner_nationality') }}">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('realestate.owner_phone') }} :</label>
                                    <input type="text" name="owner_phone" class="form-control" value="{{ old('owner_phone') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('realestate.owner_landline') }} :</label>
                                    <input type="text" name="owner_landline" class="form-control" value="{{ old('owner_landline') }}">
                                </div>
                            </div>
                        </div>

                        <!-- القسم الأيسر: البيانات البنكية، الحسابات والمرفقات -->
                        <div class="col-md-6">
                            <h6 class="text-primary font-weight-bold mb-3"><i class="fas fa-university ml-1"></i> {{ __('realestate.financial_details') }}</h6>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.owner_address') }} :</label>
                                <input type="text" name="owner_address" class="form-control" value="{{ old('owner_address') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.owner_email') }} :</label>
                                <input type="email" name="owner_email" class="form-control" value="{{ old('owner_email') }}">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('realestate.bank_name') }} :</label>
                                    <select name="bank_name" class="form-control">
                                        <option value="" disabled selected>اختر البنك...</option>
                                        @foreach(__('realestate.saudi_banks_list') as $key => $bankName)
                                            <option value="{{ $bankName }}" {{ old('bank_name') == $bankName ? 'selected' : '' }}>
                                                {{ $bankName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('realestate.account_number') }} :</label>
                                    <input type="text" name="account_number" class="form-control" value="{{ old('account_number') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.iban') }} :</label>
                                <input type="text" name="iban" class="form-control" value="{{ old('iban') }}" placeholder="SA0000000000000000000000">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.commission_rate') }} :</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="commission_rate" class="form-control" value="{{ old('commission_rate', '2.5') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('realestate.insurance_account') }} :</label>
                                    <select name="insurance_account" class="form-control">
                                        <option value="المكتب">{{ __('realestate.office') }}</option>
                                        <option value="المالك">{{ __('realestate.owner') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('realestate.water_account') }} :</label>
                                    <select name="water_account" class="form-control">
                                        <option value="المكتب">{{ __('realestate.office') }}</option>
                                        <option value="المالك">{{ __('realestate.owner') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.product_notes') }} :</label>
                                <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.unit_media') }} :</label>
                                <input type="file" name="media[]" class="form-control" multiple accept="image/*,video/*">
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary btn-custom px-5 shadow-sm ml-2">
                            <i class="fas fa-save ml-1"></i> {{ __('realestate.save') }}
                        </button>
                        <a href="{{ route('properties.index') }}" class="btn btn-danger btn-custom px-5 shadow-sm">
                            <i class="fas fa-times ml-1"></i> {{ __('realestate.cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection