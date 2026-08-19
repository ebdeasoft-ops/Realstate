@extends('layouts.master')

@section('css')
<style>
    .card-header-custom { background: #fff; border-bottom: 1px solid #eee; padding: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
    .btn-custom { border-radius: 8px; font-weight: 600; padding: 6px 15px; }
</style>
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('title') 
{{ __('realestate.add_property_expense') ?? 'إدخال مصروفات العقارات' }} 
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <h4 class="content-title mb-0">{{ __('realestate.property_expenses') ?? 'مصروفات العقارات' }}</h4>
</div>
<!-- عرض رسالة النجاح -->
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- عرض رسائل الخطأ العامة (التي يتم إرجاعها من الـ catch) -->
@if ($errors->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $errors->first('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <!-- Header -->
            <div class="card-header-custom">
                <h5 class="mb-0 text-primary"><i class="fas fa-wrench mr-2"></i> {{ __('realestate.add_property_expense') ?? 'إدخال مصروفات العقارات' }}</h5>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('property_expenses.index') }}" class="btn btn-secondary btn-custom shadow-sm">
                        <i class="fas fa-arrow-right"></i> {{ __('realestate.back') ?? 'عودة' }}
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('property_expenses.store') }}" method="POST" autocomplete="off">
                    @csrf
                    
                    <!-- اختر العقار -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('realestate.select_property') ?? 'اختر العقار' }}</label>
                        <select name="property_id" id="property_id" class="form-control select2" required>
                            <option value="">{{ __('realestate.choose_property') ?? 'اختر العقار...' }}</option>
                            @foreach($properties as $property)
                                <option value="{{ $property->id }}" {{ old('property_id') == $property->id ? 'selected' : '' }}>
                                    {{ $property->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- اختر الوحدة -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('realestate.select_unit') ?? 'اختر الوحدة' }}</label>
                        <select name="unit_id" id="unit_id" class="form-control select2">
                            <option value="">{{ __('realestate.general_expense') ?? 'عام (على العقار ككل)' }}</option>
                            @if(isset($units))
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->name ?? $unit->unit_number }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- نوع المصروف -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('realestate.expense_type') ?? 'نوع المصروف' }}</label>
                        <select name="expense_type" class="form-control select2" required>
                            <option value="">{{ __('realestate.choose_expense_type') ?? 'اختر نوع المصروف...' }}</option>
                            <option value="water" {{ old('expense_type') == 'water' ? 'selected' : '' }}>{{ __('realestate.water') ?? 'ماء' }}</option>
                            <option value="electricity" {{ old('expense_type') == 'electricity' ? 'selected' : '' }}>{{ __('realestate.electricity') ?? 'كهرباء' }}</option>
                            <option value="maintenance" {{ old('expense_type') == 'maintenance' ? 'selected' : '' }}>{{ __('realestate.general_maintenance') ?? 'صيانة عامة' }}</option>
                            <option value="other" {{ old('expense_type') == 'other' ? 'selected' : '' }}>{{ __('realestate.other') ?? 'أخرى' }}</option>
                        </select>
                    </div>

                    <!-- المبلغ المصروف -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('realestate.expense_amount') ?? 'المبلغ المصروف' }}</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount') }}" required>
                            <div class="input-group-append">
                                <span class="input-group-text">ريال</span>
                            </div>
                        </div>
                    </div>

                    <!-- تاريخ المصروف -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('realestate.expense_date') ?? 'تاريخ المصروف' }}</label>
                        <input type="date" name="expense_date" class="form-control" value="{{ old('expense_date', date('Y-m-d')) }}" required>
                    </div>

                    <!-- طريقة الدفع -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('realestate.payment_method') ?? 'طريقة الدفع' }}</label>
                        <select name="payment_method" class="form-control select2" required>
                            <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>{{ __('realestate.cash') ?? 'نقدي (كاش)' }}</option>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>{{ __('realestate.bank_transfer') ?? 'تحويل بنكي' }}</option>
                        </select>
                    </div>

                    <!-- بيان المصروفات -->
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('realestate.expense_statement') ?? 'بيان المصروفات' }}</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>

                    <!-- زر الحفظ -->
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-custom px-4 shadow-sm">
                            <i class="fas fa-save"></i> {{ __('realestate.save') ?? 'حفظ' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            dir: "rtl",
            width: '100%'
        });
    });
</script>
@endsection