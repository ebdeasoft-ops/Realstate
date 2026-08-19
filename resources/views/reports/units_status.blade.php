@extends('layouts.master')

@section('title')
{{ __('report.units_status_report') }}
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between no-print">
    <h4 class="content-title mb-0">{{ __('report.units_status_report') }}</h4>
</div>
@endsection

@section('content')
<style>
    :root {
        --pw-navy: #1b3358;
        --pw-navy-light: #23395D;
        --pw-border: #e3e7ee;
        --pw-radius: 10px;
        --pw-shadow: 0 4px 6px rgba(0, 0, 0, .05);
    }

    /* ---------- هيدر الصفحة ---------- */
    .pw-page-header {
        background: linear-gradient(135deg, var(--pw-navy) 0%, var(--pw-navy-light) 100%);
        border-radius: var(--pw-radius);
        min-height: 96px;
        padding: 22px 26px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: var(--pw-shadow);
        margin-bottom: 22px;
    }

    .pw-page-header .pw-header-icon {
        width: 52px;
        height: 52px;
        min-width: 52px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #fff;
    }

    .pw-page-header h4 {
        color: #fff !important;
        font-weight: 700;
        margin: 0 !important;
        font-size: 20px;
    }

    .pw-page-header .pw-header-sub {
        color: rgba(255, 255, 255, .8);
        font-size: 13px;
        margin-top: 2px;
    }

    /* ---------- كارت الفلاتر ---------- */
    .pw-search-card {
        border: none !important;
        border-radius: var(--pw-radius) !important;
        box-shadow: var(--pw-shadow) !important;
        overflow: hidden;
    }

    .pw-search-card .card-body {
        padding: 24px 22px;
    }

    .pw-search-card .form-label,
    .pw-search-card label {
        font-weight: 600;
        color: var(--pw-navy);
        font-size: 13.5px;
        margin-bottom: 6px;
        display: block;
    }

    .pw-search-card .form-label i,
    .pw-search-card label i {
        color: var(--pw-navy-light) !important;
    }

    .pw-search-card .form-control,
    .pw-search-card .select2-container .select2-selection--single {
        border: 1px solid var(--pw-border) !important;
        border-radius: 8px !important;
        height: 44px !important;
        display: flex;
        align-items: center;
        font-size: 13.5px;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .pw-search-card .form-control:focus {
        border-color: var(--pw-navy-light) !important;
        box-shadow: 0 0 0 3px rgba(27, 51, 88, .12) !important;
    }

    .select2-container .select2-selection__rendered {
        line-height: 44px !important;
    }

    .select2-container .select2-selection__arrow {
        height: 42px !important;
    }

    .pw-search-card .btn-primary {
        background: linear-gradient(135deg, var(--pw-navy) 0%, var(--pw-navy-light) 100%) !important;
        border: none !important;
        border-radius: 8px !important;
        height: 44px;
        font-weight: 600;
        letter-spacing: .3px;
        box-shadow: 0 4px 10px rgba(27, 51, 88, .25);
        transition: transform .15s ease, box-shadow .15s ease;
    }

    .pw-search-card .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(27, 51, 88, .32);
    }

    /* ---------- كارت وجدول النتائج ---------- */
    .pw-results-card {
        border: none !important;
        border-radius: var(--pw-radius) !important;
        box-shadow: var(--pw-shadow) !important;
        overflow: hidden;
    }

    .pw-results-card .card-body {
        padding: 0;
    }

    .pw-results-card .table {
        margin-bottom: 0;
    }

    .pw-results-card .table thead th {
        background: linear-gradient(135deg, var(--pw-navy) 0%, var(--pw-navy-light) 100%);
        color: #fff;
        border: none;
        font-weight: 600;
        font-size: 13px;
        padding: 14px 12px;
        white-space: nowrap;
    }

    .pw-results-card .table tbody td {
        vertical-align: middle;
        padding: 13px 12px;
        font-size: 13.5px;
        border-color: var(--pw-border);
    }

    .pw-results-card .table tbody tr {
        transition: background .15s ease;
    }

    .pw-results-card .table tbody tr:hover {
        background: rgba(27, 51, 88, .04);
    }

    .pw-results-card .table tbody tr.table-success {
        background: rgba(40, 167, 69, .07) !important;
    }

    .pw-results-card .table tbody tr.table-success:hover {
        background: rgba(40, 167, 69, .12) !important;
    }

    /* ---------- الشارات ---------- */
    .pw-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }

    .pw-badge.pw-badge-available {
        background: rgba(40, 167, 69, .12);
        color: #1e7e34;
    }

    .pw-badge.pw-badge-rented {
        background: rgba(108, 117, 125, .14);
        color: #495057;
    }

    /* ---------- زرار التأجير الآن ---------- */
    .pw-btn-rent {
        background: linear-gradient(135deg, var(--pw-navy) 0%, var(--pw-navy-light) 100%) !important;
        border: none !important;
        border-radius: 999px !important;
        padding: 7px 16px !important;
        font-size: 12.5px;
        font-weight: 600;
        color: #fff !important;
        box-shadow: 0 3px 8px rgba(27, 51, 88, .25);
        transition: transform .15s ease, box-shadow .15s ease;
    }

    .pw-btn-rent:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 12px rgba(27, 51, 88, .32);
        color: #fff !important;
    }

    .pw-expire-text {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #dc3545;
        font-weight: 700;
        font-size: 12.5px;
    }

    .pw-empty-state {
        padding: 46px 10px;
        text-align: center;
        color: #9aa5b5;
    }

    .pw-empty-state i {
        font-size: 34px;
        display: block;
        margin-bottom: 10px;
        color: var(--pw-border);
    }
</style>

<br>
<div class="row">
    <div class="col-md-12 mb-3">
        <div class="pw-page-header">
            <div class="pw-header-icon">
                <i class="fas fa-building"></i>
            </div>
            <div>
                <h4>{{ __('report.units_status_report') }}</h4>
                <div class="pw-header-sub">{{ __('report.units_status_report') }}</div>
            </div>
        </div>
    </div>

    <!-- فلاتر البحث -->
    <div class="col-md-12 mb-4">
        <div class="card pw-search-card">
            <div class="card-body">
                <form method="GET" action="{{ route('report.units_status') }}">
                    <div class="row align-items-end">

                        <!-- فلتر نوع الوحدة -->
                        <div class="col-md-4">
                            <div class="form-group-custom">
                                <label class="form-label">
                                    <i class="fas fa-home mr-1"></i> {{ __('realestate.unit_type') }}
                                </label>
                                <select name="unit_type_id" class="form-control select2">
                                    <option value="" selected>{{ __('realestate.choose_unit_type') }}</option>
                                    @foreach($unitTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ request('unit_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- فلتر الحالة -->
                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="fas fa-filter mr-1"></i> {{ __('report.status') }}
                            </label>
                            <select name="status_filter" class="form-control">
                                <option value="">{{ __('report.all_statuses') }}</option>
                                <option value="available"
                                    {{ request('status_filter') == 'available' ? 'selected' : '' }}>
                                    {{ __('report.available_only') }}
                                </option>
                                <option value="expiring_soon"
                                    {{ request('status_filter') == 'expiring_soon' ? 'selected' : '' }}>
                                    {{ __('report.expiring_soon') }}
                                </option>
                            </select>
                        </div>

                        <!-- زر البحث -->
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-search"></i> {{ __('report.search') }}
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- جدول النتائج -->
    <div class="col-md-12">
        <div class="card pw-results-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>{{ __('report.unit_number') }}</th>
                                <th>{{ __('report.unit_type') }}</th>
                                <th>{{ __('report.property') }}</th>
                                <th>{{ __('report.status') }}</th>
                                <th>{{ __('report.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($units as $unit)
                            <tr class="{{ $unit->status == 'available' ? 'table-success' : '' }}">
                                <!-- رقم الوحدة -->
                                <td>{{ $unit->unit_number }}</td>

                                <!-- اسم نوع الوحدة (مصحح عبر العلاقة) -->
                                <td>{{ optional($unit->unitType)->name ?? '---' }}</td>

                                <!-- اسم العقار -->
                                <td>{{ optional($unit->property)->name ?? '---' }}</td>

                                <!-- حالة الوحدة -->
                                <td>
                                    @if($unit->is_rented == 0)
                                    <span class="pw-badge pw-badge-available">
                                        <i class="fas fa-check-circle"></i> {{ __('report.available') }}
                                    </span>
                                    @else
                                    <span class="pw-badge pw-badge-rented">
                                        <i class="fas fa-lock"></i> {{ __('report.rented') }}
                                    </span>
                                    @endif
                                </td>

                                <!-- الإجراءات وتاريخ الانتهاء -->
                                <td>
                                    @if($unit->is_rented == 0 || !$unit->activeContract)
                                    <a href="{{ route('contracts.create', ['unit_id' => $unit->id]) }}"
                                        class="pw-btn-rent">
                                        <i class="fas fa-file-contract"></i> {{ __('report.rent_now') }}
                                    </a>
                                    @else
                                    <span class="pw-expire-text">
                                        <i class="fas fa-clock"></i>
                                        {{ __('report.expires_at') }}:
                                        {{ optional($unit->activeContract)->end_date ?? '---' }}
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <div class="pw-empty-state">
                                        <i class="fas fa-inbox"></i>
                                        {{ __('report.no_data') }}
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection