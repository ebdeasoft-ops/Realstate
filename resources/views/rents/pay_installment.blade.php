@extends('layouts.master')

@section('title')
    {{ __('realestate.payment_screen') ?? 'شاشة سداد الأقساط' }}
@stop

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fa-solid fa-file-invoice-dollar ml-2"></i> {{ __('realestate.pay_installment_num') ?? 'تسديد قسط رقم' }} ({{ $installment->installment_number }})</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('installments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="installment_id" value="{{ $installment->id }}">
                        <input type="hidden" name="tenant_id" value="{{ $installment->tenant_id }}">

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">{{ __('realestate.tenant') ?? 'اسم المستأجر' }}:</label>
                            <input type="text" class="form-control" value="{{ $installment->tenantData->name ?? __('realestate.not_specified') }}" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">{{ __('realestate.total_amount') ?? 'إجمالي القسط' }}:</label>
                            <input type="text" class="form-control" value="{{ number_format($installment->amount, 2) }} ر.س" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-danger">{{ __('realestate.current_remaining') ?? 'المتبقي عليه حالياً' }}:</label>
                            <input type="text" class="form-control text-danger font-weight-bold" value="{{ number_format($remaining, 2) }} ر.س" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-success">{{ __('realestate.amount_to_pay') ?? 'المبلغ المراد سداده الآن' }}:</label>
                            <input type="number" step="0.01" max="{{ $remaining }}" min="1" name="amount" class="form-control" placeholder="{{ __('realestate.enter_amount') ?? 'أدخل المبلغ...' }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">{{ __('realestate.payment_method') ?? 'طريقة الدفع' }}:</label>
                            <select name="pay_method" class="form-control" required>
                                <option value="cash">{{ __('realestate.cash') ?? 'نقداً' }}</option>
                                <option value="bank">{{ __('realestate.bank_transfer') ?? 'تحويل بنكي' }}</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">{{ __('realestate.payment_date') ?? 'تاريخ الدفع' }}:</label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-success px-4"><i class="fa-solid fa-check ml-1"></i> {{ __('realestate.confirm_payment') ?? 'تأكيد السداد' }}</button>
                            <a href="{{ route('installments.index') }}" class="btn btn-secondary px-3">{{ __('realestate.cancel') ?? 'إلغاء' }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection