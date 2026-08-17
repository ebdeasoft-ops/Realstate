@extends('layouts.master')

@section('css')
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('title')
{{ __('realestate.new_contract') }}
@stop

@section('page-header')
<div class="main-parent">
    <div class="breadcrumb-header justify-content-between parent-heading">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><i class="fas fa-file-contract text-primary ml-2"></i>
                    {{ __('realestate.new_contract') }}</h4>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')

@if (session()->has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle ml-2"></i> <strong>{{ session()->get('success') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if (count($errors) > 0)
<div class="alert alert-danger">
    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong><i class="fas fa-exclamation-triangle ml-1"></i> خطأ</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card shadow-sm border-0 pt-4" style="border-radius: 12px;">
            <div class="card-body pb-0">
                <form action="{{ route('lease_contracts.store') }}" method="post" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf

                    {{-- القسم الأول: بيانات العقد والوحدة والمستأجر الأساسية --}}
                    <div class="card bg-light border-0 mb-4 p-3" style="border-radius: 8px;">
                        <h5 class="text-primary mb-3 font-weight-bold" style="font-size: 15px;">
                            <i class="fas fa-building ml-1"></i> بيانات العقد والوحدة والمستأجر
                        </h5>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="unit_id" class="control-label parent-label">اختر العقار والوحدة <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-door-open"></i></span></div>
                                    <select name="unit_id" id="unit_id" class="form-control select2" required>
                                        <option value="" selected disabled>اختر الوحدة الشاغرة...</option>
                                        @foreach($units as $unit)
                                        <option value="{{ $unit->id }}">
                                            {{ $unit->property->name ?? 'عقار غير معروف' }} - الوحدة رقم:
                                            {{ $unit->unit_number }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="tenant_id" class="control-label parent-label">اسم المستأجر <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-user"></i></span></div>
                                    <select name="tenant_id" id="tenant_id" class="form-control select2" required>
                                        <option value="" selected disabled>اختر المستأجر...</option>
                                        @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label for="contract_number" class="control-label parent-label">رقم العقد</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-id-card"></i></span></div>
                                    <input type="text" class="form-control parent-input" id="contract_number"
                                        name="contract_number" placeholder="رقم العقد">
                                </div>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label for="contract_type" class="control-label parent-label">غرض الإيجار</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-store"></i></span></div>
                                    <select class="form-control parent-input" id="contract_type" name="contract_type"
                                        required>
                                        <option value="" disabled selected>اختر غرض الإيجار...</option>
                                        <option value="سكني" {{ old('contract_type') == 'سكني' ? 'selected' : '' }}>سكني
                                        </option>
                                        <option value="تجاري" {{ old('contract_type') == 'تجاري' ? 'selected' : '' }}>
                                            تجاري (يخضع للضريبة)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label for="electricity_meter" class="control-label parent-label">رقم عداد
                                    الكهرباء</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-bolt"></i></span></div>
                                    <input type="text" class="form-control parent-input" id="electricity_meter"
                                        name="electricity_meter" placeholder="رقم العداد">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- القسم الثاني: التواريخ والقيم المالية والدفعات --}}
                    <div class="card bg-light border-0 mb-4 p-3" style="border-radius: 8px;">
                        <h5 class="text-primary mb-3 font-weight-bold" style="font-size: 15px;">
                            <i class="fas fa-money-bill-wave ml-1"></i> التواريخ، الإيجار، والقيم المالية
                        </h5>
                        <div class="row">
                            <div class="col-lg-4 mb-3">
                                <label for="start_date" class="control-label parent-label">بداية العقد <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-calendar-plus"></i></span></div>
                                    <input type="date" class="form-control parent-input" id="start_date"
                                        name="start_date" required>
                                </div>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label for="end_date" class="control-label parent-label">نهاية العقد <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-calendar-minus"></i></span></div>
                                    <input type="date" class="form-control parent-input" id="end_date" name="end_date"
                                        required>
                                </div>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label for="contract_date" class="control-label parent-label">تاريخ العقد</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-calendar"></i></span></div>
                                    <input type="date" class="form-control parent-input" id="contract_date"
                                        name="contract_date">
                                </div>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label for="rent_amount" class="control-label parent-label">الإيجار السنوي <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-dollar-sign"></i></span></div>
                                    <input type="number" step="0.01" class="form-control parent-input" id="rent_amount"
                                        name="rent_amount" placeholder="0.00" required>
                                </div>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label for="payment_every" class="control-label parent-label">الإيجار يدفع كل
                                    (بالأشهر)</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-redo"></i></span></div>
                                    <input type="number" class="form-control parent-input" id="payment_every"
                                        name="payment_every" value="6" placeholder="مثال: 6">
                                </div>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label for="installment_amount" class="control-label parent-label">قيمة القسط</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-coins"></i></span></div>
                                    <input type="number" step="0.01" class="form-control parent-input"
                                        id="installment_amount" name="installment_amount" placeholder="0.00">
                                </div>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label for="insurance_amount" class="control-label parent-label">مبلغ التأمين</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-shield-alt"></i></span></div>
                                    <input type="number" step="0.01" class="form-control parent-input"
                                        id="insurance_amount" name="insurance_amount" placeholder="0.00">
                                </div>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label for="commission" class="control-label parent-label">العمولة</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-handshake"></i></span></div>
                                    <input type="number" step="0.01" class="form-control parent-input" id="commission"
                                        name="commission" placeholder="0.00">
                                </div>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label for="annual_commission" class="control-label parent-label">العمولة
                                    السنوية</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-percent"></i></span></div>
                                    <input type="number" step="0.01" class="form-control parent-input"
                                        id="annual_commission" name="annual_commission" placeholder="0.00">
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="water_bill" class="control-label parent-label">المياه</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-tint"></i></span></div>
                                    <input type="number" step="0.01" class="form-control parent-input" id="water_bill"
                                        name="water_bill" placeholder="0.00">
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="paid_amount" class="control-label parent-label">المبلغ المدفوع</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-money-check-alt"></i></span></div>
                                    <input type="number" step="0.01" class="form-control parent-input" id="paid_amount"
                                        name="paid_amount" placeholder="0.00">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- القسم الثالث: بيانات الضامن والممثل والملاحظات والملفات --}}
                    <div class="card bg-light border-0 mb-4 p-3" style="border-radius: 8px;">
                        <h5 class="text-primary mb-3 font-weight-bold" style="font-size: 15px;">
                            <i class="fas fa-user-shield ml-1"></i> بيانات الضامن، التمثيل والمرفقات
                        </h5>
                        <div class="row">
                            <div class="col-lg-4 mb-3">
                                <label for="represented_by" class="control-label parent-label">يمثله في العقد</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-user-tie"></i></span></div>
                                    <input type="text" class="form-control parent-input" id="represented_by"
                                        name="represented_by" placeholder="مثال: نفسه">
                                </div>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label for="guarantor_name" class="control-label parent-label">اسم الضامن</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-user-friends"></i></span></div>
                                    <input type="text" class="form-control parent-input" id="guarantor_name"
                                        name="guarantor_name" placeholder="اسم الضامن">
                                </div>
                            </div>

                            <div class="col-lg-4 mb-3">
                                <label for="guarantor_phone" class="control-label parent-label">هاتف الضامن</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-phone"></i></span></div>
                                    <input type="text" class="form-control parent-input" id="guarantor_phone"
                                        name="guarantor_phone" placeholder="05xxxxxxxx">
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="tenant_image" class="control-label parent-label">صورة المستأجر / مرفقات
                                    العقد</label>
                                <input type="file" class="form-control" id="tenant_image" name="tenant_image">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="notes" class="control-label parent-label">ملاحظات العقد</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fas fa-sticky-note"></i></span></div>
                                    <input type="text" class="form-control parent-input" id="notes" name="notes"
                                        placeholder="ملاحظات إضافية">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- زر الحفظ --}}
                    <div class="d-flex justify-content-center mb-4 pt-2">
                        <button
                            style="background-color: #419BB2; border-color: #419BB2; padding: 10px 30px; font-size: 16px;"
                            type="submit" class="btn btn-primary shadow-sm">
                            <i class="fas fa-save ml-2"></i> {{ __('realestate.save_data') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script>
$(document).ready(function() {
    $('.select2').select2({
        width: '100%'
    });
});
</script>
@endsection