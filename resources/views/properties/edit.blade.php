@extends('layouts.master')

@section('title')
{{ __('realestate.edit_property') ?? 'تعديل العقار' }}
@endsection

@section('css')
<style>
    .card-custom { border: none; border-radius: 12px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); }
    .section-title { font-size: 1.1rem; font-weight: 700; color: #4e73df; margin-bottom: 1.2rem; border-bottom: 2px solid #f8f9fc; padding-bottom: 8px; }
    .form-control { border-radius: 8px; padding: 10px 15px; height: calc(1.5em + 1rem + 2px); font-size: 0.95rem; border: 1px solid #d1d3e2; }
    .form-control:focus { border-color: #4e73df; box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25); }
    textarea.form-control { height: auto; }
    .form-label { font-weight: 600; color: #3a3b45; font-size: 0.9rem; margin-bottom: 0.4rem; }
    .media-card { transition: 0.3s; border-radius: 10px; overflow: hidden; background: #fff; }
    .media-card:hover { transform: scale(1.02); box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); }
</style>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between mb-4">
    <h4 class="content-title mb-0 text-primary font-weight-bold">
        <i class="fas fa-edit mr-2"></i> {{ __('realestate.edit_property') }}: {{ $property->name }}
    </h4>
    <a href="{{ route('properties.index') }}" class="btn btn-secondary btn-sm px-3 shadow-sm">
        <i class="fas fa-arrow-right mr-1"></i> {{ __('realestate.back') }}
    </a>
</div>
@endsection

@section('content')
<div class="container-fluid py-2">
    <div class="card card-custom mb-4">
        <div class="card-body p-4">

            <form action="{{ route('properties.update', $property->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- القسم الأيمن: بيانات العقار والمالك الأساسية -->
                    <div class="col-md-6 border-left">
                        <div class="section-title">
                            <i class="fas fa-home mr-2"></i> {{ __('realestate.property_details') }}
                        </div>

                        <!-- قائمة نوع العقار -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('realestate.unit_type') }} :</label>
                            <select name="property_category" class="form-control" required>
                                <option value="" disabled>{{ __('realestate.choose_unit_type') }}</option>
                                @foreach(__('realestate.unit_types_list') as $key => $label)
                                    <option value="{{ $key }}" {{ old('property_category', $property->property_category) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('realestate.property_name') }} :</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $property->name) }}" required>
                        </div>

                        <!-- خانة الحالة -->
                        <div class="mb-3">
                            <label class="form-label">{{ __('realestate.status') ?? 'الحالة' }} :</label>
                            <select name="status" class="form-control" required>
                                <option value="مفعل" {{ old('status', $property->status) == 'مفعل' ? 'selected' : '' }}>{{ __('realestate.active') ?? 'مفعل' }}</option>
                                <option value="غير مفعل" {{ old('status', $property->status) == 'غير مفعل' ? 'selected' : '' }}>{{ __('realestate.inactive') ?? 'غير مفعل' }}</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('realestate.address') }} :</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', $property->address) }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('realestate.city') }} :</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city', $property->city) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('realestate.district') }} :</label>
                                <input type="text" name="district" class="form-control" value="{{ old('district', $property->district) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('realestate.owner') }} :</label>
                            <select name="owner_id" class="form-control" required>
                                @foreach($owners as $owner)
                                    <option value="{{ $owner->id }}" {{ old('owner_id', $property->owner_id) == $owner->id ? 'selected' : '' }}>
                                        {{ $owner->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('realestate.owner_id_number') }} :</label>
                                <input type="text" name="owner_id_number" class="form-control" value="{{ old('owner_id_number', $property->owner_id_number) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('realestate.owner_nationality') }} :</label>
                                <input type="text" name="owner_nationality" class="form-control" value="{{ old('owner_nationality', $property->owner_nationality) }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('realestate.owner_phone') }} :</label>
                                <input type="text" name="owner_phone" class="form-control" value="{{ old('owner_phone', $property->owner_phone) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('realestate.owner_landline') }} :</label>
                                <input type="text" name="owner_landline" class="form-control" value="{{ old('owner_landline', $property->owner_landline) }}">
                            </div>
                        </div>
                    </div>

                    <!-- القسم الأيسر: البيانات البنكية، الحسابات والمرفقات -->
                    <div class="col-md-6">
                        <div class="section-title">
                            <i class="fas fa-university mr-2"></i> {{ __('realestate.financial_and_regulatory_data') }}
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('realestate.owner_address') }} :</label>
                            <input type="text" name="owner_address" class="form-control" value="{{ old('owner_address', $property->owner_address) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('realestate.owner_email') }} :</label>
                            <input type="email" name="owner_email" class="form-control" value="{{ old('owner_email', $property->owner_email) }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('realestate.bank_name') }} :</label>
                                <select name="bank_name" class="form-control">
                                    <option value="" disabled>اختر البنك...</option>
                                    @foreach(__('realestate.saudi_banks_list') as $key => $bankName)
                                        <option value="{{ $bankName }}" {{ old('bank_name', $property->bank_name) == $bankName ? 'selected' : '' }}>
                                            {{ $bankName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('realestate.account_number') }} :</label>
                                <input type="text" name="account_number" class="form-control" value="{{ old('account_number', $property->account_number) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('realestate.iban') }} :</label>
                            <input type="text" name="iban" class="form-control" value="{{ old('iban', $property->iban) }}" placeholder="SA0000000000000000000000">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('realestate.status_type') }} :</label>
                                <select name="type" class="form-control" required>
                                    <option value="rent" {{ old('type', $property->type) == 'rent' ? 'selected' : '' }}>{{ __('realestate.rent') }}</option>
                                    <option value="sale" {{ old('type', $property->type) == 'sale' ? 'selected' : '' }}>{{ __('realestate.sale') }}</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('realestate.annual_rent') }} :</label>
                                <input type="number" step="0.01" name="annual_rent" class="form-control" value="{{ old('annual_rent', $property->annual_rent) }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('realestate.commission_rate') }} :</label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="commission_rate" class="form-control" value="{{ old('commission_rate', $property->commission_rate) }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('realestate.insurance_account') }} :</label>
                                <select name="insurance_account" class="form-control">
                                    <option value="المكتب" {{ old('insurance_account', $property->insurance_account) == 'المكتب' ? 'selected' : '' }}>{{ __('realestate.office') }}</option>
                                    <option value="المالك" {{ old('insurance_account', $property->insurance_account) == 'المالك' ? 'selected' : '' }}>{{ __('realestate.owner') }}</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ __('realestate.water_account') }} :</label>
                                <select name="water_account" class="form-control">
                                    <option value="المكتب" {{ old('water_account', $property->water_account) == 'المكتب' ? 'selected' : '' }}>{{ __('realestate.office') }}</option>
                                    <option value="المالك" {{ old('water_account', $property->water_account) == 'المالك' ? 'selected' : '' }}>{{ __('realestate.owner') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('realestate.product_notes') }} :</label>
                            <textarea name="description" class="form-control" rows="2">{{ old('description', $property->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- قسم عرض المرفقات الحالية -->
                <div class="section-title">
                    <i class="fas fa-images mr-2"></i> {{ __('realestate.current_attachments') }}
                </div>
                
                <div class="row mb-4">
                    @forelse($property->media as $media)
                        <div class="col-md-3 mb-3 text-center">
                            <div class="media-card border p-2 shadow-sm">
                                @if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $media->file_path))
                                    <img src="{{ asset('storage/' . $media->file_path) }}" class="rounded w-100" style="height: 140px; object-fit: cover;">
                                @else
                                    <video class="rounded w-100" style="height: 140px; object-fit: cover;" controls>
                                        <source src="{{ asset('storage/' . $media->file_path) }}">
                                    </video>
                                @endif
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $media->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary btn-block">
                                        <i class="fas fa-eye mr-1"></i> عرض الملف
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-light text-center border py-3 text-muted">
                                <i class="fas fa-info-circle mr-1"></i> {{ __('realestate.no_attachments') }}
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- رفع مرفقات جديدة -->
                <div class="mb-4 bg-light p-3 rounded border">
                    <label class="form-label font-weight-bold text-primary"><i class="fas fa-cloud-upload-alt mr-1"></i> {{ __('realestate.add_new_attachments') }}</label>
                    <input type="file" name="media[]" class="form-control-file border p-2 bg-white rounded w-100" multiple accept="image/*,video/*">
                    <small class="form-text text-muted mt-1">يمكنك اختيار أكثر من صورة أو فيديو في نفس الوقت.</small>
                </div>

                <div class="text-center mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-success px-5 shadow-sm ml-2">
                        <i class="fas fa-save mr-1"></i> {{ __('realestate.save_changes') }}
                    </button>
                    <a href="{{ route('properties.index') }}" class="btn btn-secondary px-5 shadow-sm">
                        <i class="fas fa-times mr-1"></i> {{ __('realestate.cancel') }}
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection