@extends('layouts.master')

@section('css')
<style>
    .report-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .report-title { border-bottom: 2px solid #ffc107; padding-bottom: 12px; margin-bottom: 20px; }
    @media print {
        main, header, nav, aside, .sidebar, .breadcrumb-header, .no-print { display: none !important; }
        #reportContainer, .report-card { width: 100% !important; margin: 0 !important; padding: 0 !important; border: none !important; box-shadow: none !important; }
        body { background-color: #fff !important; }
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('title')
{{ __('contracts.expiring_contracts_report') }}
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between no-print">
    <h4 class="content-title mb-0">{{ __('contracts.expiring_contracts_report') }}</h4>
</div>
@endsection

@section('content')
<div class="row">
    <!-- فلاتر البحث -->
    <div class="col-md-12 mb-4 no-print">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="GET" action="{{ route('report.expiring_contracts') }}" autocomplete="off">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <label class="font-weight-bold">{{ __('contracts.tenant') }}</label>
                            <select name="tenant_id" class="form-control select2">
                                <option value="">{{ __('contracts.all_tenants') }}</option>
                                @foreach($tenants as $tenant)
                                    <option value="{{ $tenant->id }}" {{ request('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                        {{ $tenant->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="font-weight-bold">{{ __('contracts.expires_within') }}</label>
                            <input type="number" name="period_value" class="form-control" value="{{ request('period_value', 30) }}" placeholder="{{ __('contracts.placeholder_period') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="font-weight-bold">{{ __('contracts.period_type') }}</label>
                            <select name="period_type" class="form-control">
                                <option value="days" {{ request('period_type', 'days') == 'days' ? 'selected' : '' }}>{{ __('contracts.days') }}</option>
                                <option value="months" {{ request('period_type', 'months') == 'months' ? 'selected' : '' }}>{{ __('contracts.months') }}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-search"></i> {{ __('contracts.search_filter') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12" id="reportContainer">
        
        <!-- قسم العقود المنتهية بالفعل -->
        <div class="report-card mb-4 border-danger">
            <div class="d-flex justify-content-between align-items-center report-title mb-4" style="border-bottom-color: #dc3545;">
                <h4 class="text-danger font-weight-bold"><i class="fas fa-times-circle"></i> {{ __('contracts.expired_contracts') }}</h4>
                <button onclick="window.print()" class="btn btn-success btn-sm no-print">
                    <i class="fas fa-print"></i> {{ __('contracts.print_report') }}
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>{{ __('contracts.contract_number') }}</th>
                            <th>{{ __('contracts.tenant') }}</th>
                            <th>{{ __('contracts.unit') }}</th>
                            <th>{{ __('contracts.start_date') }}</th>
                            <th>{{ __('contracts.end_date') }}</th>
                            <th>{{ __('contracts.total_amount') }}</th>
                            <th class="no-print">{{ __('contracts.whatsapp_reminder') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expiredContracts as $contract)
                        @php
                            $tenant = optional($contract->tenant);
                            $phone = optional($tenant)->phone ?? '';
                            $tenantPhone = preg_replace('/^0/', '+966', ltrim($phone));   
                            $whatsappMessage = urlencode("تنبيه: عقد الإيجار رقم ({$contract->contract_number}) الخاص بك قد انتهى بتاريخ {$contract->end_date}. نرجو سرعة مراجعة الإدارة.");
                        @endphp
                        <tr>
                            <td>{{ $contract->contract_number }}</td>
                            <td>{{ $tenant->name ?? '---' }}</td>
                            <td>{{ optional($contract->unit)->unit_number ?? '---' }}</td>
                            <td>{{ $contract->start_date }}</td>
                            <td class="text-danger font-weight-bold">
                                {{ $contract->end_date }}
                                <br>
                                <span class="badge bg-danger text-white mt-1" style="background-color: #dc3545; padding: 3px 7px; border-radius: 4px; font-size: 11px;">منتهي بالفعل</span>
                            </td>
                            <td>{{ number_format($contract->rent_amount, 2) }}</td>
                            <td class="no-print">
                                @if(!empty($tenant->phone))
                                    <a href="https://wa.me/{{ $tenantPhone }}?text={{ $whatsappMessage }}" target="_blank" class="btn btn-success btn-sm">
                                        <i class="fab fa-whatsapp"></i> واتساب
                                    </a>
                                @else
                                    <span class="text-muted small">{{ __('contracts.no_phone') }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-muted py-3">لا توجد عقود منتهية في هذه الفترة.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- قسم العقود التي سوف تنتهي قريباً -->
        <div class="report-card border-success">
            <div class="d-flex justify-content-between align-items-center report-title mb-4" style="border-bottom-color: #28a745;">
                <h4 class="text-success font-weight-bold"><i class="fas fa-clock"></i> {{ __('contracts.upcoming_contracts') }}</h4>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>{{ __('contracts.contract_number') }}</th>
                            <th>{{ __('contracts.tenant') }}</th>
                            <th>{{ __('contracts.unit') }}</th>
                            <th>{{ __('contracts.start_date') }}</th>
                            <th>{{ __('contracts.end_date') }}</th>
                            <th>{{ __('contracts.total_amount') }}</th>
                            <th class="no-print">{{ __('contracts.whatsapp_reminder') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($upcomingContracts as $contract)
                        @php
                            $tenant = optional($contract->tenant);
                            $phone = optional($tenant)->phone ?? '';
                            $tenantPhone = preg_replace('/^0/', '+966', ltrim($phone));   
                            $whatsappMessage = urlencode("تذكير بانتهاء عقد الإيجار رقم ({$contract->contract_number}) الخاص بك في تاريخ {$contract->end_date}. نرجو مراجعة الإدارة.");
                        @endphp
                        <tr>
                            <td>{{ $contract->contract_number }}</td>
                            <td>{{ $tenant->name ?? '---' }}</td>
                            <td>{{ optional($format = $contract->unit)->unit_number ?? '---' }}</td>
                            <td>{{ $contract->start_date }}</td>
                            <td class="text-success font-weight-bold">
                                {{ $contract->end_date }}
                                <br>
                                <span class="badge bg-success text-white mt-1" style="background-color: #28a745; padding: 3px 7px; border-radius: 4px; font-size: 11px;">سوف ينتهي قريباً</span>
                            </td>
                            <td>{{ number_format($contract->rent_amount, 2) }}</td>
                            <td class="no-print">
                                @if(!empty($tenant->phone))
                                    <a href="https://wa.me/{{ $tenantPhone }}?text={{ $whatsappMessage }}" target="_blank" class="btn btn-success btn-sm">
                                        <i class="fab fa-whatsapp"></i> واتساب
                                    </a>
                                @else
                                    <span class="text-muted small">{{ __('contracts.no_phone') }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-muted py-3">لا توجد عقود شارف على الانتهاء في هذه الفترة.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({ dir: "{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}", width: '100%' });
    });
</script>
@endsection