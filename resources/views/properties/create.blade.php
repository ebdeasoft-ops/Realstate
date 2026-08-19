@extends('layouts.master')

@section('css')
<style>
.card-header-custom {
    background: #f8f9fa;
    border-bottom: 1px solid #eee;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.btn-custom {
    border-radius: 8px;
    font-weight: 600;
    padding: 8px 20px;
}

.form-label {
    font-weight: bold;
    color: #333;
}

.section-title {
    font-size: 1.1rem;
    border-bottom: 2px solid #007bff;
    padding-bottom: 5px;
    margin-bottom: 20px;
}
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
                <h5 class="mb-0 text-primary"><i class="fas fa-building mr-2"></i> {{ __('realestate.add_property') }}
                </h5>
                <a href="{{ route('properties.index') }}" class="btn btn-secondary btn-custom">
                    <i class="fas fa-arrow-right"></i> {{ __('realestate.back') }}
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf

                    <div class="row">
                        <!-- القسم الأيمن: بيانات العقار الأساسية -->
                        <div class="col-md-6 border-left">
                            <h6 class="text-primary font-weight-bold mb-3 section-title"><i
                                    class="fas fa-home ml-1"></i> {{ __('realestate.property_details') }}</h6>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.unit_type') }} :</label>
                                <select name="property_category" class="form-control" required>
                                    <option value="" disabled selected>{{ __('realestate.choose_unit_type') }}</option>
                                    @foreach(\App\Models\UnitType::all() as $type)
                                    <option value="{{ $type->id }}"
                                        {{ old('property_category') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.listing_type') ?? 'نوع العرض' }} :</label>
                                <select name="type" class="form-control" required>
                                    <option value="" disabled selected>
                                        {{ __('realestate.choose_listing_type') ?? 'اختر نوع العرض...' }}</option>
                                    <option value="sale" {{ old('type') == 'sale' ? 'selected' : '' }}>
                                        {{ __('realestate.for_sale') ?? 'للبيع' }}</option>
                                    <option value="rent" {{ old('type') == 'rent' ? 'selected' : '' }}>
                                        {{ __('realestate.for_rent') ?? 'للإيجار' }}</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.property_name') ?? 'اسم العقار' }} :</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.status') ?? 'الحالة' }} :</label>
                                <select name="status" class="form-control" required>
                                    <option value="" disabled selected>
                                        {{ __('realestate.choose_status') ?? 'اختر الحالة...' }}</option>
                                    <option value="مفعل" {{ old('status') == 'مفعل' ? 'selected' : '' }}>
                                        {{ __('realestate.active') ?? 'مفعل' }}</option>
                                    <option value="غير مفعل" {{ old('status') == 'غير مفعل' ? 'selected' : '' }}>
                                        {{ __('realestate.inactive') ?? 'غير مفعل' }}</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.address') }} :</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.city') ?? 'المدينة' }} :</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city') }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.district') ?? 'الحي' }} :</label>
                                <input type="text" name="district" class="form-control" value="{{ old('district') }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.commission_rate') }} :</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="commission_rate" class="form-control"
                                        value="{{ old('commission_rate', '2.5') }}">
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
                                <textarea name="description" class="form-control"
                                    rows="2">{{ old('description') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.unit_media') }} :</label>
                                <input type="file" name="media[]" class="form-control" multiple
                                    accept="image/*,video/*">
                            </div>
                        </div>

                        <!-- القسم الأيسر: بيانات المالك والحسابات البنكية -->
                        <div class="col-md-6">
                            <h6 class="text-primary font-weight-bold mb-3 section-title"><i
                                    class="fas fa-user-tie ml-1"></i>
                                {{ __('realestate.owner_details') ?? 'بيانات المالك والبنك' }}</h6>

                            <!-- اختيار المالك -->
                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.owner_name') }} :</label>
                                <select name="owner_id" id="ownerSelect" class="form-control" required>
                                    <option value="" disabled selected>
                                        {{ __('realestate.choose_property') ?? 'اختر المالك...' }}</option>
                                    @foreach($owners as $owner)
                                    <option value="{{ $owner->id }}"
                                        {{ old('owner_id') == $owner->id ? 'selected' : '' }}>
                                        {{ $owner->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- عنوان المالك والبريد -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('realestate.owner_address') }} :</label>
                                    <input type="text" name="owner_address" id="owner_address" class="form-control"
                                        value="{{ old('owner_address') }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('realestate.owner_email') }} :</label>
                                    <input type="email" name="owner_email" id="owner_email" class="form-control"
                                        value="{{ old('owner_email') }}">
                                </div>
                            </div>

                            <!-- بيانات الهوية والجنسية والجوال -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">{{ __('realestate.owner_id_number') }} :</label>
                                    <input type="text" name="owner_id_number" id="owner_id_number" class="form-control"
                                        value="{{ old('owner_id_number') }}" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">{{ __('realestate.owner_nationality') }} :</label>
                                    <input type="text" name="owner_nationality" id="owner_nationality"
                                        class="form-control" value="{{ old('owner_nationality') }}" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">{{ __('realestate.owner_phone') }} :</label>
                                    <input type="text" name="owner_phone" id="owner_phone" class="form-control"
                                        value="{{ old('owner_phone') }}" readonly>
                                </div>
                            </div>

                            <hr class="my-3">

                            <!-- الحسابات البنكية -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('realestate.bank_name') }} :</label>
                                    <input type="text" name="bank_name" id="bank_name" class="form-control"
                                        value="{{ old('bank_name') }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('realestate.bank_account') ?? 'رقم الحساب' }}
                                        :</label>
                                    <input type="text" name="bank_account_number" id="bank_account_number"
                                        class="form-control" value="{{ old('bank_account_number') }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('realestate.iban') }} :</label>
                                <input type="text" name="iban" id="iban" class="form-control" value="{{ old('iban') }}"
                                    readonly>
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

@section('js')
<script>
$(document).ready(function() {
    const ownersData = @json($owners -> keyBy('id'));

    $('#ownerSelect').on('change', function() {
        let ownerId = $(this).val();
        let owner = ownersData[ownerId];

        console.log("Selected Owner Data:", owner); // تتبع البيانات في الـ Console

        if (owner) {
            $('#owner_id_number').val(owner.national_id || '');
            $('#owner_nationality').val(owner.nationality || '');
            $('#owner_phone').val(owner.phone || '');
            $('#owner_address').val(owner.address || '');
            $('#bank_name').val(owner.bank_name || '');
            $('#bank_account_number').val(owner.bank_account || '');
            $('#iban').val(owner.iban || '');
        } else {
            // تفريغ الحقول في حال لم يتم اختيار مالك
            $('#owner_id_number').val('');
            $('#owner_nationality').val('');
            $('#owner_phone').val('');
            $('#owner_address').val('');
            $('#bank_name').val('');
            $('#bank_account_number').val('');
            $('#iban').val('');
        }
    });
});
</script>
@endsection