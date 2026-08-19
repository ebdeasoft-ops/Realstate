@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Tajawal', Arial, sans-serif; background: #f4f6f9; }

        .page-card { border-radius: 14px; border: none; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }

        /* ===== KPI Cards ===== */
        .kpi-card {
            border-radius: 14px; padding: 22px; color: #fff; position: relative; overflow: hidden;
            box-shadow: 0 6px 16px rgba(0,0,0,0.12); margin-bottom: 22px; min-height: 128px;
        }
        .kpi-card .kpi-icon {
            position: absolute; left: 16px; top: 16px; font-size: 2.4rem; opacity: 0.25;
        }
        .kpi-card h6 { opacity: 0.9; font-weight: 500; margin-bottom: 6px; font-size: 0.85rem; }
        .kpi-card h2 { font-weight: 900; margin-bottom: 4px; }
        .kpi-card small { opacity: 0.85; }
        .kpi-blue    { background: linear-gradient(135deg,#3b82f6,#2563eb); }
        .kpi-green   { background: linear-gradient(135deg,#22c55e,#16a34a); }
        .kpi-orange  { background: linear-gradient(135deg,#f59e0b,#d97706); }
        .kpi-purple  { background: linear-gradient(135deg,#8b5cf6,#7c3aed); }
        .kpi-teal    { background: linear-gradient(135deg,#14b8a6,#0d9488); }
        .kpi-red     { background: linear-gradient(135deg,#ef4444,#dc2626); }
        .kpi-indigo  { background: linear-gradient(135deg,#6366f1,#4f46e5); }

        /* ===== Section headers ===== */
        .section-heading {
            font-weight: 800; color: #1e293b; margin-bottom: 18px; display:flex; align-items:center; gap:8px;
        }
        .section-heading i { color: #2563eb; }

        /* ===== Chart card ===== */
        .chart-card .card-header {
            background: #fff; border-bottom: 1px solid #eef1f5; font-weight: 700; padding: 16px 20px;
        }
        .chart-wrap { position: relative; height: 260px; }
        .chart-wrap-sm { position: relative; height: 220px; }

        /* ===== Tables ===== */
        .table-modern thead th {
            background: #f8f9fc; color: #64748b; font-weight: 700; font-size: 0.78rem;
            text-transform: uppercase; border: none; padding: 12px 14px;
        }
        .table-modern tbody td { padding: 12px 14px; vertical-align: middle; font-size: 0.9rem; border-color: #f1f3f8; }
        .badge-status-active   { background:#dcfce7; color:#16a34a; padding:5px 12px; border-radius:20px; font-weight:700; font-size:0.75rem; }
        .badge-status-inactive { background:#fee2e2; color:#dc2626; padding:5px 12px; border-radius:20px; font-weight:700; font-size:0.75rem; }
        .badge-type-rent { background:#dbeafe; color:#2563eb; padding:4px 10px; border-radius:20px; font-size:0.72rem; font-weight:700; }
        .badge-type-sale { background:#fce7f3; color:#db2777; padding:4px 10px; border-radius:20px; font-size:0.72rem; font-weight:700; }

        .owner-rank {
            width: 30px; height: 30px; border-radius: 50%; background:#eef2ff; color:#4338ca;
            display:flex; align-items:center; justify-content:center; font-weight:800; font-size:0.85rem;
        }

        .empty-state { text-align:center; padding: 40px 10px; color:#94a3b8; }
        .empty-state i { font-size: 2rem; margin-bottom: 10px; display:block; }

        /* ===== Search / Listings ===== */
        .search-card { background:#fff; border-radius: 14px; padding: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); margin-bottom: 22px; }
        .search-card .form-label { font-weight:700; color:#475569; font-size:0.82rem; margin-bottom:6px; }
        .listing-row-rent { border-right: 4px solid #3b82f6; }
        .listing-row-sale { border-right: 4px solid #ec4899; }
        .badge-available   { background:#dcfce7; color:#16a34a; padding:5px 12px; border-radius:20px; font-weight:700; font-size:0.75rem; }
        .badge-unavailable { background:#f1f5f9; color:#64748b; padding:5px 12px; border-radius:20px; font-weight:700; font-size:0.75rem; }

        /* حالة تحميل بسيطة أثناء الـ AJAX */
        #listingsResultsWrap.is-loading { opacity: 0.45; pointer-events: none; transition: opacity .15s ease; }
        #listingsSearchIcon.is-loading { animation: spin 0.7s linear infinite; }
        @keyframes spin { from { transform: rotate(0deg);} to { transform: rotate(360deg);} }
    </style>
@endsection

@section('title')
    {{ __('dashboard.dashboard_title') }}
@stop

@section('page-header')
<div class="breadcrumb-header justify-content-between align-items-center my-4 p-3 bg-white shadow-sm" style="border-radius: 15px;">
    <div class="my-auto">
        <h4 class="content-title mb-0 font-weight-bold text-primary">
            <i class="fas fa-building text-primary ml-2"></i> {{ __('dashboard.dashboard_title') }}
        </h4>
        <small class="text-muted">{{ __('dashboard.dashboard_subtitle', ['date' => \Carbon\Carbon::now()->translatedFormat('d F Y')]) }}</small>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">

    {{-- ==========================================================
         1. المؤشرات الأساسية (KPIs)
    =========================================================== --}}
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-6">
            <div class="kpi-card kpi-indigo">
                <i class="fas fa-building kpi-icon"></i>
                <h6>{{ __('dashboard.kpi_total_properties') }}</h6>
                <h2>{{ number_format($totalProperties ?? 0) }}</h2>
                <small>{{ __('dashboard.kpi_total_properties_desc') }}</small>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6">
            <div class="kpi-card kpi-blue">
                <i class="fas fa-city kpi-icon"></i>
                <h6>{{ __('dashboard.kpi_total_units') }}</h6>
                <h2>{{ number_format($totalUnits ?? 0) }}</h2>
                <small>{{ __('dashboard.kpi_total_units_desc', ['rented' => $rentedUnits ?? 0, 'available' => $availableUnits ?? 0]) }}</small>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-6">
            <div class="kpi-card kpi-green">
                <i class="fas fa-file-signature kpi-icon"></i>
                <h6>{{ __('dashboard.kpi_active_contracts') }}</h6>
                <h2>{{ number_format($activeContractsCount ?? 0) }}</h2>
                <small>{{ __('dashboard.kpi_active_contracts_desc', ['count' => $inactiveContractsCount ?? 0]) }}</small>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="kpi-card kpi-purple">
                <i class="fas fa-users kpi-icon"></i>
                <h6>{{ __('dashboard.kpi_tenants_owners') }}</h6>
                <h2>{{ number_format($totalTenants ?? 0) }}</h2>
                <small>{{ __('dashboard.kpi_tenants_owners_desc', ['count' => $totalLandlords ?? 0]) }}</small>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="kpi-card kpi-orange">
                <i class="fas fa-percentage kpi-icon"></i>
                <h6>{{ __('dashboard.kpi_occupancy') }}</h6>
                <h2>{{ $occupancyRate ?? 0 }}%</h2>
                <small>{{ __('dashboard.kpi_occupancy_desc', ['total' => $totalUnits ?? 0]) }}</small>
            </div>
        </div>
    </div>

    {{-- ==========================================================
         2. بحث الوحدات المتاحة (بيع / إيجار) — AJAX بدون Reload
    =========================================================== --}}
    <h6 class="section-heading"><i class="fas fa-search"></i> {{ __('dashboard.search_section_title') }}</h6>
    <div class="search-card">
        <form id="listingsSearchForm" action="{{ route('dashboard.search-listings') }}" method="GET" class="row align-items-end">
            <div class="col-md-3 col-6 mb-3 mb-md-0">
                <label class="form-label">{{ __('dashboard.filter_listing_type') }}</label>
                <select name="listing_type" class="form-control">
                    <option value="">{{ __('dashboard.filter_all') }}</option>
                    <option value="rent" {{ ($filters['listing_type'] ?? '') == 'rent' ? 'selected' : '' }}>{{ __('dashboard.filter_for_rent') }}</option>
                    <option value="sale" {{ ($filters['listing_type'] ?? '') == 'sale' ? 'selected' : '' }}>{{ __('dashboard.filter_for_sale') }}</option>
                </select>
            </div>

            <div class="col-md-3 col-6 mb-3 mb-md-0">
                <label class="form-label">{{ __('dashboard.filter_city') }}</label>
                <select name="city" class="form-control">
                    <option value="">{{ __('dashboard.filter_all_cities') }}</option>
                    @foreach($listingCities ?? [] as $city)
                        <option value="{{ $city }}" {{ ($filters['city'] ?? '') == $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 col-6 mb-3 mb-md-0">
                <label class="form-label">{{ __('dashboard.filter_unit_type') }}</label>
                <select name="category" class="form-control">
                    <option value="">{{ __('dashboard.filter_all_types') }}</option>
                    @foreach($listingCategories ?? [] as $cat)
                        <option value="{{ $cat }}" {{ ($filters['category'] ?? '') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 col-6 mb-3 mb-md-0">
                <label class="form-label">{{ __('dashboard.filter_status') }}</label>
                <select name="availability" class="form-control">
                    <option value="">{{ __('dashboard.filter_all') }}</option>
                    <option value="available" {{ ($filters['availability'] ?? '') == 'available' ? 'selected' : '' }}>{{ __('dashboard.filter_available_only') }}</option>
                </select>
            </div>

            <div class="col-md-1 col-12">
                <button type="submit" class="btn btn-primary btn-block btn-custom" title="{{ __('dashboard.search_button') }}">
                    <i class="fas fa-search" id="listingsSearchIcon"></i>
                </button>
            </div>
        </form>
    </div>

    <div class="card page-card mb-4">
        <div class="card-body p-0" id="listingsResultsWrap">
            @include('partials.listings-results')
        </div>
    </div>

    {{-- ==========================================================
         3. تحصيلات الشهر الحالي
    =========================================================== --}}
    <h6 class="section-heading"><i class="fas fa-wallet"></i> {{ __('dashboard.collections_section_title') }}</h6>
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="card page-card mb-4 border-right border-success border-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">{{ __('dashboard.collected') }}</h6>
                        <h3 class="text-success font-weight-bold mb-0">{{ number_format($currentMonthPaidInstallments ?? 0, 2) }} <small class="fs-6">ر.س</small></h3>
                        <small class="text-muted">{{ __('dashboard.collected_count', ['count' => $currentMonthPaidCount ?? 0]) }}</small>
                    </div>
                    <div class="p-3 bg-success-transparent rounded-circle text-success"><i class="fas fa-check-circle fa-2x"></i></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card page-card mb-4 border-right border-danger border-4">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">{{ __('dashboard.uncollected') }}</h6>
                        <h3 class="text-danger font-weight-bold mb-0">{{ number_format($currentMonthUnpaidInstallments ?? 0, 2) }} <small class="fs-6">ر.س</small></h3>
                        <small class="text-muted">{{ __('dashboard.uncollected_count', ['count' => $currentMonthUnpaidCount ?? 0]) }}</small>
                    </div>
                    <div class="p-3 bg-danger-transparent rounded-circle text-danger"><i class="fas fa-exclamation-circle fa-2x"></i></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12">
            <div class="card page-card mb-4 border-right border-info border-4">
                <div class="card-body">
                    <h6 class="text-muted mb-2">{{ __('dashboard.collection_rate') }}</h6>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h3 class="text-info font-weight-bold mb-0">{{ $collectionRate ?? 0 }}%</h3>
                        <i class="fas fa-chart-line text-info fa-2x opacity-50"></i>
                    </div>
                    <div class="progress" style="height:8px; border-radius:10px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $collectionRate ?? 0 }}%; border-radius:10px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==========================================================
         4. الرسوم البيانية التحليلية
    =========================================================== --}}
    <h6 class="section-heading"><i class="fas fa-chart-pie"></i> {{ __('dashboard.analytics_section_title') }}</h6>
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="card page-card chart-card mb-4">
                <div class="card-header"><i class="fas fa-tag text-primary ml-1"></i> {{ __('dashboard.chart_rent_vs_sale') }}</div>
                <div class="card-body">
                    <div class="chart-wrap-sm"><canvas id="rentVsSaleChart"></canvas></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card page-card chart-card mb-4">
                <div class="card-header"><i class="fas fa-home text-primary ml-1"></i> {{ __('dashboard.chart_category') }}</div>
                <div class="card-body">
                    <div class="chart-wrap-sm"><canvas id="categoryChart"></canvas></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card page-card chart-card mb-4">
                <div class="card-header"><i class="fas fa-door-open text-primary ml-1"></i> {{ __('dashboard.chart_occupancy') }}</div>
                <div class="card-body">
                    <div class="chart-wrap-sm"><canvas id="occupancyChart"></canvas></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card page-card chart-card mb-4">
                <div class="card-header"><i class="fas fa-chart-line text-primary ml-1"></i> {{ __('dashboard.chart_revenue_trend') }}</div>
                <div class="card-body">
                    <div class="chart-wrap"><canvas id="revenueTrendChart"></canvas></div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card page-card chart-card mb-4">
                <div class="card-header"><i class="fas fa-map-marker-alt text-primary ml-1"></i> {{ __('dashboard.chart_address') }}</div>
                <div class="card-body">
                    <div class="chart-wrap"><canvas id="addressChart"></canvas></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ==========================================================
         5. أفضل الملاك + أقرب الأقساط المستحقة
    =========================================================== --}}
    <div class="row">
        <div class="col-lg-5">
            <div class="card page-card mb-4">
                <div class="card-header bg-white py-3"><i class="fas fa-crown text-warning ml-1"></i> {{ __('dashboard.top_owners_title') }}</div>
                <div class="card-body p-0">
                    @if(($topOwners ?? collect())->count())
                        <table class="table table-modern mb-0">
                            <tbody>
                                @foreach($topOwners as $i => $owner)
                                    <tr>
                                        <td style="width:40px;"><span class="owner-rank">{{ $i + 1 }}</span></td>
                                        <td class="font-weight-bold">{{ $owner->name }}</td>
                                        <td class="text-left text-muted">{{ __('dashboard.properties_count', ['count' => $owner->properties_count]) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state"><i class="fas fa-inbox"></i> {{ __('dashboard.top_owners_empty') }}</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card page-card mb-4">
                <div class="card-header bg-white py-3"><i class="fas fa-clock text-danger ml-1"></i> {{ __('dashboard.upcoming_installments_title') }}</div>
                <div class="card-body p-0">
                    @if(($upcomingInstallments ?? collect())->count())
                        <div class="table-responsive">
                            <table class="table table-modern mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('dashboard.due_date') }}</th>
                                        <th>{{ __('dashboard.amount') }}</th>
                                        <th>{{ __('dashboard.paid_amount') }}</th>
                                        <th>{{ __('dashboard.table_status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($upcomingInstallments as $inst)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($inst->due_date)->translatedFormat('d M Y') }}</td>
                                            <td>{{ number_format($inst->amount ?? 0, 2) }} ر.س</td>
                                            <td>{{ number_format($inst->paid_amount ?? 0, 2) }} ر.س</td>
                                            <td><span class="badge-status-inactive">{{ __('dashboard.due_status') }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state"><i class="fas fa-check-double"></i> {{ __('dashboard.upcoming_installments_empty') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ==========================================================
         6. أحدث العقود
    =========================================================== --}}
    <h6 class="section-heading"><i class="fas fa-file-contract"></i> {{ __('dashboard.latest_contracts_title') }}</h6>
    <div class="card page-card mb-4">
        <div class="card-body p-0">
            @if(($latestContracts ?? collect())->count())
                <div class="table-responsive">
                    <table class="table table-modern mb-0">
                        <thead>
                            <tr>
                                <th>{{ __('dashboard.contract_number') }}</th>
                                <th>{{ __('dashboard.tenant') }}</th>
                                <th>{{ __('dashboard.unit') }}</th>
                                <th>{{ __('dashboard.start_date') }}</th>
                                <th>{{ __('dashboard.end_date') }}</th>
                                <th>{{ __('dashboard.rent_value') }}</th>
                                <th>{{ __('dashboard.table_status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($latestContracts as $contract)
                                <tr>
                                    <td class="font-weight-bold">#{{ $contract->contract_number ?? $contract->id }}</td>
                                    <td>{{ $contract->tenant->name ?? '—' }}</td>
                                    <td>{{ $contract->unit->unit_number ?? '—' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($contract->start_date)->translatedFormat('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($contract->end_date)->translatedFormat('d M Y') }}</td>
                                    <td>{{ number_format($contract->rent_amount ?? 0, 2) }} ر.س</td>
                                    <td>
                                        @if(($contract->status ?? 0) == 1)
                                            <span class="badge-status-active">{{ __('dashboard.status_active_contract') }}</span>
                                        @else
                                            <span class="badge-status-inactive">{{ __('dashboard.status_ended_contract') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state"><i class="fas fa-file-contract"></i> {{ __('dashboard.latest_contracts_empty') }}</div>
            @endif
        </div>
    </div>

</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.font.family = "'Tajawal', Arial, sans-serif";

    // ===== 1. بيع مقابل إيجار =====
    new Chart(document.getElementById('rentVsSaleChart'), {
        type: 'doughnut',
        data: {
            labels: ['{{ __('dashboard.filter_for_rent') }}', '{{ __('dashboard.filter_for_sale') }}'],
            datasets: [{
                data: [{{ $unitsForRent ?? 0 }}, {{ $unitsForSale ?? 0 }}],
                backgroundColor: ['#3b82f6', '#ec4899'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, padding: 15 } } }
        }
    });

    // ===== 2. توزيع الوحدات حسب النوع =====
    const categoryLabels = @json($unitsByCategory->pluck('property_category'));
    const categoryData = @json($unitsByCategory->pluck('total'));
    new Chart(document.getElementById('categoryChart'), {
        type: 'polarArea',
        data: {
            labels: categoryLabels,
            datasets: [{
                data: categoryData,
                backgroundColor: ['#6366f1','#22c55e','#f59e0b','#ec4899','#14b8a6','#ef4444','#8b5cf6']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, padding: 12, font: { size: 10 } } } }
        }
    });

    // ===== 3. حالة الإشغال =====
    new Chart(document.getElementById('occupancyChart'), {
        type: 'doughnut',
        data: {
            labels: ['{{ __('dashboard.chart_legend_rented') }}', '{{ __('dashboard.chart_legend_available') }}'],
            datasets: [{
                data: [{{ $rentedUnits ?? 0 }}, {{ $availableUnits ?? 0 }}],
                backgroundColor: ['#f59e0b', '#22c55e'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, padding: 15 } } }
        }
    });

    // ===== 4. اتجاه التحصيل (آخر 6 أشهر) =====
    const revenueMonths = @json($monthlyRevenue->pluck('month'));
    const revenueTotals = @json($monthlyRevenue->pluck('total'));
    new Chart(document.getElementById('revenueTrendChart'), {
        type: 'line',
        data: {
            labels: revenueMonths,
            datasets: [{
                label: '{{ __('dashboard.chart_legend_collected') }}',
                data: revenueTotals,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#2563eb',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // ===== 5. توزيع العقارات حسب المدينة =====
    const addressLabels = @json($unitsByAddress->pluck('address'));
    const rentData = @json($unitsByAddress->pluck('rent_count'));
    const saleData = @json($unitsByAddress->pluck('sale_count'));
    new Chart(document.getElementById('addressChart'), {
        type: 'bar',
        data: {
            labels: addressLabels,
            datasets: [
                { label: '{{ __('dashboard.chart_legend_rent') }}', data: rentData, backgroundColor: '#3b82f6', borderRadius: 6 },
                { label: '{{ __('dashboard.chart_legend_sale') }}', data: saleData, backgroundColor: '#ec4899', borderRadius: 6 }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { x: { grid: { display: false } }, y: { beginAtZero: true } },
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // ===== 6. بحث الوحدات المتاحة عبر AJAX (بدون إعادة تحميل الصفحة) =====
    $(document).ready(function () {
        const $form   = $('#listingsSearchForm');
        const $wrap   = $('#listingsResultsWrap');
        const $icon   = $('#listingsSearchIcon');

        function runSearch(pushState) {
            const query = $form.serialize();

            $wrap.addClass('is-loading');
            $icon.addClass('is-loading');

            $.get($form.attr('action'), query)
                .done(function (html) {
                    $wrap.html(html);

                    // تحديث الرابط في المتصفح بدون عمل reload، عشان يقدر المستخدم يعمل مشاركة/رجوع
                    if (pushState && window.history && window.history.pushState) {
                        const newUrl = window.location.pathname + '?' + query;
                        window.history.pushState({ path: newUrl }, '', newUrl);
                    }
                })
                .fail(function () {
                    $wrap.html('<div class="empty-state"><i class="fas fa-exclamation-triangle"></i> حدث خطأ أثناء البحث، حاول مرة أخرى</div>');
                })
                .always(function () {
                    $wrap.removeClass('is-loading');
                    $icon.removeClass('is-loading');
                });
        }

        // عند الضغط على زرار البحث
        $form.on('submit', function (e) {
            e.preventDefault();
            runSearch(true);
        });

        // بحث فوري عند تغيير أي فلتر (اختياري، لسهولة الاستخدام)
        $form.on('change', 'select', function () {
            runSearch(true);
        });
    });
</script>
@endsection