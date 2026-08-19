@extends('layouts.master')

@section('css')
    <style>
        .report-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        .report-title {
            border-bottom: 2px solid #dc3545;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        @media print {

            main,
            header,
            nav,
            aside,
            .sidebar,
            .breadcrumb-header,
            .no-print {
                display: none !important;
            }

            #reportContainer,
            .report-card {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                border: none !important;
                box-shadow: none !important;
            }

            body {
                background-color: #fff !important;
            }
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('title')
    {{ __('report.delayed_installments_report') }}
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between no-print">
        <h4 class="content-title mb-0">{{ __('report.delayed_installments_report') }}</h4>
    </div>
@endsection

@section('content')
    <div class="row">
        <!-- فلاتر البحث المتقدمة -->
        <div class="col-md-12 mb-4 no-print">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form method="GET" action="{{ route('report.delayed_installments') }}" autocomplete="off">
                        <div class="row align-items-end">
                            <!-- فلتر المستأجر -->
                            <div class="col-md-3">
                                <label class="font-weight-bold">{{ __('report.tenant') }}</label>
                                <select name="tenant_id" class="form-control select2">
                                    <option value="">{{ __('report.all_tenants') }}</option>
                                    @foreach($tenants as $tenant)
                                        <option value="{{ $tenant->id }}" {{ request('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                            {{ $tenant->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- فلتر العقار (من جدول unit) -->
                            <div class="col-md-3">
                                <label class="font-weight-bold">{{ __('report.property') }}</label>
                                <select name="property_id" class="form-control select2">
                                    <option value="">{{ __('report.all_properties') }}</option>
                                    @foreach($properties as $id => $name)
                                        <option value="{{ $id }}" {{ request('property_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- مدة التأخير -->
                            <div class="col-md-2">
                                <label class="font-weight-bold">{{ __('report.delay_duration') }}</label>
                                <input type="number" name="delay_value" class="form-control"
                                    value="{{ request('delay_value') }}" placeholder="{{ __('report.placeholder_delay') }}">
                            </div>

                            <!-- نوع مدة التأخير -->
                            <div class="col-md-2">
                                <label class="font-weight-bold">{{ __('report.delay_type') }}</label>
                                <select name="delay_type" class="form-control">
                                    <option value="days" {{ request('delay_type') == 'days' ? 'selected' : '' }}>
                                        {{ __('report.days') }}</option>
                                    <option value="months" {{ request('delay_type') == 'months' ? 'selected' : '' }}>
                                        {{ __('report.months') }}</option>
                                </select>
                            </div>

                            <!-- زر البحث -->
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-search"></i> {{ __('report.search_and_filter') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- جدول النتائج -->
        <div class="col-md-12">
            <div class="report-card" id="reportContainer">
                <div class="d-flex justify-content-between align-items-center report-title mb-4">
                    <div>
                        <h4 class="text-danger font-weight-bold mb-1">
                            <i class="fas fa-exclamation-triangle"></i> {{ __('report.delayed_installments_report') }}
                        </h4>
                    </div>
                    <button onclick="window.print()" class="btn btn-success btn-sm no-print">
                        <i class="fas fa-print"></i> {{ __('report.print_report') }}
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="thead-light">
                            <tr>
                                <th>{{ __('report.tenant') }}</th>
                                <th>{{ __('report.contract_number') }}</th>
                                <th>{{ __('report.unit') }}</th>
                                <th>{{ __('report.installment_number') }}</th>
                                <th>إجمالي القسط</th>
                                <th>المدفوع</th>
                                <th>المتبقي (المتأخر)</th>
                                <th>{{ __('report.due_date') }}</th>
                                <th>الحالة</th>
                                <th class="no-print">{{ __('report.whatsapp_reminder') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($delayedInstallments as $installment)
                                @php
                                    $tenantName = optional($installment->tenantData)->name ?? '---';
                                    $phone = optional($installment->tenantData)->phone ?? '';
                                    $tenantPhone = preg_replace('/^0/', '+966', ltrim($phone));
                                    $contractNum = optional($installment->contract)->contract_number ?? $installment->contract_id;
                                    $unitNumber = optional($installment->UnitData)->unit_number ?? '---';

                                    $totalAmount = $installment->amount;
                                    $paidAmount = $installment->paid_amount ?? 0;
                                    $remainingAmount = $totalAmount - $paidAmount;

                                    $dueDate = $installment->due_date;

                                    $whatsappMessage = "خطاب تذكير\n\nعناية / {$tenantName} المحترم،\nالسلام عليكم ورحمة الله وبركاته، وبعد:\n\nنذكركم بوجود أقساط متأخرة/مسددة جزئياً مستحقة السداد حتى تاريخ {$dueDate}.\n\nعلماً بأن المبلغ المتبقي عليكم عن هذه الفترة: " . number_format($remainingAmount, 2) . " ريال.\n\nشاكرين لكم حسن تعاونكم معنا،،\nمع تحيات إدارة العقارات.";
                                    $encodedMessage = urlencode($whatsappMessage);
                                @endphp
                                <tr>
                                    <td>{{ $tenantName }}</td>
                                    <td>{{ $contractNum }}</td>
                                    <td>{{ $unitNumber }}</td>
                                    <td>{{ $installment->installment_number }}</td>
                                    <td>{{ number_format($totalAmount, 2) }}</td>
                                    <td class="text-success">{{ number_format($paidAmount, 2) }}</td>
                                    <td class="font-weight-bold text-danger">{{ number_format($remainingAmount, 2) }} ريال</td>
                                    <td class="text-danger font-weight-bold">{{ $dueDate }}</td>
                                    <td>
                                        @if($installment->status == 'unpaid')
                                            <span class="badge badge-danger">غير مسدد</span>
                                        @elseif($installment->status == 'partially_paid')
                                            <span class="badge" style="background-color: #fd7e14; color: #fff;">مسدد جزئياً</span>
                                        @endif
                                    </td>
                                    <td class="no-print">
                                        @if(!empty($tenantPhone))
                                            <a href="https://wa.me/{{ $tenantPhone }}?text={{ $encodedMessage }}" target="_blank"
                                                class="btn btn-success btn-sm">
                                                <i class="fab fa-whatsapp"></i> واتساب
                                            </a>
                                        @else
                                            <span class="text-muted small">{{ __('report.no_phone') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-muted py-4">{{ __('report.no_delayed_installments') }}</td>
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
        $(document).ready(function () {
            $('.select2').select2({ dir: "{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}", width: '100%' });
        });
    </script>
@endsection