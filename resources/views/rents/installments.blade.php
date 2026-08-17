@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body { background: #e9e5da; font-family: 'Tajawal', Arial, sans-serif; }
        .table-wrap { color: #1f2a24; }
    </style>
@endsection

@section('title')
    {{ __('realestate.rent_installments') ?? 'إدارة أقساط الإيجار' }}
@stop

@section('page-header')
    <div class="main-parent no-print">
        <div class="breadcrumb-header justify-content-between parent-heading">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">
                        <i class="fas fa-file-invoice-dollar text-primary ml-2"></i> 
                        {{ __('realestate.installments_schedule') ?? 'جدول أقساط الإيجار المرتبطة بالعقود' }}
                    </h4>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="table-wrap">
        <!-- قسم البحث والتصفية بالقوائم المنسدلة -->
        <div class="row justify-content-center mb-3">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('installments.index') }}" method="GET">
                            <div class="row align-items-end">
                                <!-- قائمة المستأجرين -->
                                <div class="col-md-3 form-group mb-2">
                                    <label class="small font-weight-bold">{{ __('realestate.tenant') ?? 'المستأجر' }}:</label>
                                    <select name="tenant_id" class="form-control form-control-sm">
                                        <option value="">-- {{ __('realestate.all_tenants') ?? 'كل المستأجرين' }} --</option>
                                        @isset($tenants)
                                            @foreach($tenants as $tenant)
                                                <option value="{{ $tenant->id }}" {{ request('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                                    {{ $tenant->name ?? 'مستأجر #' . $tenant->id }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>

                                <!-- قائمة الوحدات -->
                                <div class="col-md-2 form-group mb-2">
                                    <label class="small font-weight-bold">{{ __('realestate.unit') ?? 'الوحدة' }}:</label>
                                    <select name="unit_id" class="form-control form-control-sm">
                                        <option value="">-- {{ __('realestate.all_units') ?? 'كل الوحدات' }} --</option>
                                        @isset($units)
                                            @foreach($units as $unit)
                                                <option value="{{ $unit->id }}" {{ request('unit_id') == $unit->id ? 'selected' : '' }}>
                                                    {{ $unit->name ?? 'وحدة #' . $unit->id }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>

                                <div class="col-md-2 form-group mb-2">
                                    <label class="small font-weight-bold">{{ __('realestate.from_due_date') ?? 'من تاريخ استحقاق' }}:</label>
                                    <input type="date" name="from_date" class="form-control form-control-sm" value="{{ request('from_date') }}">
                                </div>
                                <div class="col-md-2 form-group mb-2">
                                    <label class="small font-weight-bold">{{ __('realestate.to_due_date') ?? 'إلى تاريخ استحقاق' }}:</label>
                                    <input type="date" name="to_date" class="form-control form-control-sm" value="{{ request('to_date') }}">
                                </div>
                                <div class="col-md-3 form-group mb-2 d-flex">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block ml-1"><i class="fa-solid fa-search ml-1"></i> {{ __('realestate.search') ?? 'بحث' }}</button>
                                    <a href="{{ route('installments.index') }}" class="btn btn-secondary btn-sm" title="{{ __('realestate.reset') ?? 'إعادة ضبط' }}"><i class="fa-solid fa-rotate-right"></i></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- جدول النتائج -->
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-right">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('realestate.installment_number') ?? '# القسط' }}</th>
                                        <th>{{ __('realestate.contract_id') ?? 'رقم العقد' }}</th>
                                        <th>{{ __('realestate.unit') ?? 'رقم الوحدة' }}</th>
                                        <th>{{ __('realestate.tenant') ?? 'المستأجر' }}</th>
                                        <th>{{ __('realestate.total_amount') ?? 'إجمالي القسط' }}</th>
                                        <th>{{ __('realestate.paid_amount') ?? 'المدفوع' }}</th>
                                        <th>{{ __('realestate.remaining_amount') ?? 'المتبقي' }}</th>
                                        <th>{{ __('realestate.due_date') ?? 'تاريخ الاستحقاق' }}</th>
                                        <th>{{ __('realestate.status') ?? 'الحالة' }}</th>
                                        <th>{{ __('realestate.actions') ?? 'الإجراءات' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($installments)
                                        @forelse($installments as $installment)
                                            @php
                                                $remaining = $installment->amount - $installment->paid_amount;
                                            @endphp
                                            <tr>
                                                <td><span class="badge badge-secondary">{{ $installment->installment_number }}</span></td>
                                                <td><span class="badge badge-info">{{ $installment->contract_id }}</span></td>
                                                <td>{{ $installment->unit_id }}</td>
                                                <td>{{ $installment->tenant_name ?? 'غير محدد' }}</td>
                                                <td class="font-weight-bold">{{ number_format($installment->amount, 2) }} ر.س</td>
                                                <td class="text-success">{{ number_format($installment->paid_amount, 2) }} ر.س</td>
                                                <td class="text-danger font-weight-bold">{{ number_format($remaining, 2) }} ر.س</td>
                                                <td>{{ $installment->due_date ?? '-' }}</td>
                                                <td>
                                                    @if($installment->status == 'paid')
                                                        <span class="badge badge-success">{{ __('realestate.fully_paid') ?? 'مدفوع بالكامل' }}</span>
                                                    @elseif($installment->paid_amount > 0)
                                                        <span class="badge badge-info">{{ __('realestate.partially_paid') ?? 'مسدد جزئياً' }}</span>
                                                    @else
                                                        <span class="badge badge-warning">{{ __('realestate.unpaid') ?? 'غير مدفوع' }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($remaining > 0)
                                                        <!-- تم تعديل الزر هنا ليتحول إلى رابط يوجه لصفحة السداد مباشرة -->
                                                        <a href="{{ route('installments.pay', $installment->id) }}" class="btn btn-sm btn-outline-success mb-1" title="{{ __('realestate.pay') ?? 'تسديد' }}">
                                                            <i class="fa-solid fa-money-bill-wave"></i> {{ __('realestate.pay') ?? 'تسديد' }}
                                                        </a>
                                                    @endif

                                            
                                                </td>
                                            </tr>

                                            <!-- Modal تعديل القسط -->
                                            <div class="modal fade" id="editInstallmentModal{{ $installment->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form action="{{ route('installments.update', $installment->id) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-header bg-light">
                                                                <h5 class="modal-title"><i class="fa-solid fa-pen-to-square ml-2"></i> {{ __('realestate.edit_installment') ?? 'تعديل بيانات القسط' }} ({{ $installment->installment_number }})</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-right">
                                                                <div class="form-group mb-3">
                                                                    <label>{{ __('realestate.installment_amount') ?? 'مبلغ القسط' }}:</label>
                                                                    <input type="number" step="0.01" name="amount" class="form-control" value="{{ $installment->amount }}" required>
                                                                </div>
                                                                <div class="form-group mb-3">
                                                                    <label>{{ __('realestate.due_date') ?? 'تاريخ الاستحقاق' }}:</label>
                                                                    <input type="date" name="due_date" class="form-control" value="{{ $installment->due_date }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('realestate.cancel') ?? 'إلغاء' }}</button>
                                                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save ml-1"></i> {{ __('realestate.save_changes') ?? 'حفظ التعديلات' }}</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center py-4 text-muted">{{ __('realestate.no_results') ?? 'لا توجد نتائج مطابقة للبحث' }}</td>
                                            </tr>
                                        @endforelse
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection