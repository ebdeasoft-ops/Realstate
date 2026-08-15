@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            .breadcrumb-header, .btn, .main-header, .main-sidebar, .main-footer {
                display: none !important;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
            }
            body {
                background-color: #fff !important;
            }
        }
    </style>
@endsection

@section('title')
    {{ __('realestate.tenant_details') }}
@endsection

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 text-primary font-weight-bold">
                <i class="fas fa-user-tie ml-2"></i> {{ __('realestate.tenant_details') }}: {{ $tenant->name ?? '' }}
            </h5>
            <div>
                <a href="{{ route('tenants.edit', $tenant->id) }}" class="btn btn-primary btn-sm px-3">
                    <i class="fas fa-edit ml-1"></i> {{ __('realestate.edit') }}
                </a>
                <a href="{{ route('tenants.index') }}" class="btn btn-secondary btn-sm px-3">
                    <i class="fas fa-arrow-right ml-1"></i> {{ __('realestate.back') }}
                </a>
            </div>
        </div>
        
        <div class="card-body">
            {{-- البيانات الأساسية للمستأجر --}}
            <div class="card bg-light border-0 p-3 mb-4" style="border-radius: 8px;">
                <h5 class="text-primary mb-3 font-weight-bold" style="font-size: 16px;">
                    <i class="fas fa-id-card ml-1"></i> {{ __('realestate.personal_and_financial_data') ?? 'البيانات الشخصية والمالية' }}
                </h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold text-muted">{{ __('realestate.tenant_name') }}:</label>
                        <p class="form-control-static font-weight-bold">{{ $tenant->name ?? __('realestate.not_available') }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold text-muted">{{ __('realestate.phone') }}:</label>
                        <p class="form-control-static">{{ $tenant->phone ?? __('realestate.not_available') }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold text-muted">{{ __('realestate.tax_number') ?? 'الرقم الضريبي' }}:</label>
                        <p class="form-control-static">{{ $tenant->tax_no ?? __('realestate.not_available') }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold text-muted">{{ __('realestate.address') }}:</label>
                        <p class="form-control-static">{{ $tenant->address ?? __('realestate.not_available') }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold text-muted">{{ __('realestate.balance') }}:</label>
                        <p class="form-control-static text-success font-weight-bold">{{ number_format($tenant->Balance ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>

            {{-- بيانات العقار / الشقة وفترة السداد (العقود النشطة) --}}
            <div class="card bg-light border-0 p-3 mb-4" style="border-radius: 8px;">
                <h5 class="text-primary mb-3 font-weight-bold" style="font-size: 16px;">
                    <i class="fas fa-building ml-1"></i> {{ __('realestate.unit_and_payment_period') ?? 'بيانات الشقة / الوحدة الإيجارية وفترة السداد' }}
                </h5>

                @php
                    $activeContracts = $tenant->contracts ?? $tenant->leaseContracts ?? collect();
                @endphp

                @if($activeContracts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center align-middle bg-white">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('realestate.property_name') ?? 'اسم العقار' }}</th>
                                    <th>{{ __('realestate.unit_number') ?? 'رقم الشقة / الوحدة' }}</th>
                                    <th>{{ __('realestate.start_date') ?? 'تاريخ بداية العقد' }}</th>
                                    <th>{{ __('realestate.end_date') ?? 'تاريخ نهاية العقد' }}</th>
                                    <th>{{ __('realestate.rent_amount') ?? 'قيمة الإيجار' }}</th>
                                    <th>{{ __('realestate.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeContracts as $contract)
                                    <tr>
                                        <td class="font-weight-bold">{{ $contract->unit->property->name ?? __('realestate.not_available') }}</td>
                                        <td><span class="badge badge-info">{{ $contract->unit->unit_number ?? __('realestate.not_available') }}</span></td>
                                        <td>{{ $contract->start_date ?? __('realestate.not_available') }}</td>
                                        <td>{{ $contract->end_date ?? __('realestate.not_available') }}</td>
                                        <td class="text-success font-weight-bold">{{ number_format($contract->rent_amount ?? 0, 2) }}</td>
                                        <td>
                                            @if(Route::has('lease_contracts.show'))
                                                <a href="{{ route('lease_contracts.show', $contract->id) }}" class="btn btn-sm btn-primary" title="{{ __('realestate.show') ?? 'عرض' }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    {{-- في حال لم يكن ماجراً (بيانات فاضية) --}}
                    <div class="text-center py-3 text-muted">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <p class="mb-0">{{ __('realestate.no_active_contracts_for_tenant') ?? 'لا توجد وحدات أو عقود إيجارية مسجلة لهذا المستأجر حالياً (غير ماجر).' }}</p>
                    </div>
                @endif
            </div>

            {{-- أزرار الإجراءات بالأسفل --}}
            <div class="text-center">
                <a href="{{ route('tenants.index') }}" class="btn btn-secondary px-4">
                    <i class="fas fa-list ml-1"></i> {{ __('realestate.back') ?? 'العودة للقائمة' }}
                </a>
                <a href="{{ route('tenants.edit', $tenant->id) }}" class="btn btn-primary px-4 ml-2">
                    <i class="fas fa-edit ml-1"></i> {{ __('realestate.edit_tenant') ?? 'تعديل بيانات المستأجر' }}
                </a>
                <a href="#" onclick="window.print();" class="btn btn-info px-4 text-white ml-2">
                    <i class="fas fa-print ml-1"></i> {{ __('realestate.print') ?? 'طباعة الصفحة' }}
                </a>
            </div>

        </div>
    </div>
</div>
@endsection