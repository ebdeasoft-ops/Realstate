@extends('layouts.master')

@section('title')
{{ __('realestate.property_requests') }}
@endsection

@section('css')
<style>
    .stat-card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.35rem 1rem rgba(0, 0, 0, 0.08) !important;
    }
    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }
    .table thead th {
        background-color: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        color: #475569;
        font-weight: 700;
        font-size: 0.85rem;
    }
    .table tbody tr:hover {
        background-color: #f8fafc;
    }
    .badge-pill-custom {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
    }
    .btn-whatsapp-sm {
        background-color: #25D366;
        color: #fff !important;
        border: none;
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
    }
    .btn-whatsapp-sm:hover {
        background-color: #1ebc59;
    }
    .btn-call-sm {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
    }
</style>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between mb-3">
    <div>
        <h4 class="content-title mb-1 text-primary font-weight-bold">
            <i class="fas fa-clipboard-list mr-2"></i> {{ __('realestate.property_requests') }}
        </h4>
        <p class="text-muted mb-0 font-13">{{ __('realestate.property_requests_subtitle') }}</p>
    </div>
    <div class="d-flex align-items-center">
        <a href="{{ route('property-requests.create') }}" class="btn btn-primary btn-sm shadow-sm" style="border-radius: 6px; padding: 7px 18px; font-weight: 600;">
            <i class="fas fa-plus-circle mr-1"></i> {{ __('realestate.add_property_request') }}
        </a>
    </div>
</div>
@endsection

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-lg mb-3" role="alert">
    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- بطاقات الإحصائيات -->
<div class="row mb-3">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted font-weight-bold font-12 mb-1">{{ __('realestate.total_requests') }}</div>
                        <div class="h3 mb-0 font-weight-bold text-primary">{{ $stats['total'] }}</div>
                    </div>
                    <div class="stat-icon bg-primary-transparent text-primary">
                        <i class="fas fa-layer-group"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted font-weight-bold font-12 mb-1">{{ __('realestate.status_pending') }}</div>
                        <div class="h3 mb-0 font-weight-bold text-warning">{{ $stats['pending'] }}</div>
                    </div>
                    <div class="stat-icon bg-warning-transparent text-warning">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted font-weight-bold font-12 mb-1">{{ __('realestate.status_contacted') }}</div>
                        <div class="h3 mb-0 font-weight-bold text-info">{{ $stats['contacted'] }}</div>
                    </div>
                    <div class="stat-icon bg-info-transparent text-info">
                        <i class="fas fa-phone-volume"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-muted font-weight-bold font-12 mb-1">{{ __('realestate.status_fulfilled') }}</div>
                        <div class="h3 mb-0 font-weight-bold text-success">{{ $stats['fulfilled'] }}</div>
                    </div>
                    <div class="stat-icon bg-success-transparent text-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- شريط الفلاتر والبحث -->
<div class="card shadow-sm border-0 mb-4" style="border-radius: 10px;">
    <div class="card-body p-3">
        <form action="{{ route('property-requests.index') }}" method="GET" autocomplete="off">
            <div class="row align-items-end">
                <div class="col-md-3 mb-2">
                    <label class="form-label font-weight-bold text-muted font-12 mb-1">{{ __('realestate.search') }}</label>
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="{{ __('realestate.search') }}" value="{{ request('search') }}">
                </div>

                <div class="col-md-2 mb-2">
                    <label class="form-label font-weight-bold text-muted font-12 mb-1">{{ __('realestate.status') }}</label>
                    <select name="status" class="form-control form-control-sm">
                        <option value="all">{{ __('realestate.all') }}</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('realestate.status_pending') }}</option>
                        <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>{{ __('realestate.status_contacted') }}</option>
                        <option value="fulfilled" {{ request('status') == 'fulfilled' ? 'selected' : '' }}>{{ __('realestate.status_fulfilled') }}</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('realestate.status_cancelled') }}</option>
                    </select>
                </div>

                <div class="col-md-2 mb-2">
                    <label class="form-label font-weight-bold text-muted font-12 mb-1">{{ __('realestate.unit_type') }}</label>
                    <select name="unit_type_id" class="form-control form-control-sm">
                        <option value="all">{{ __('realestate.all') }}</option>
                        @foreach($unitTypes as $type)
                        <option value="{{ $type->id }}" {{ request('unit_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 mb-2">
                    <label class="form-label font-weight-bold text-muted font-12 mb-1">{{ __('realestate.request_purpose') }}</label>
                    <select name="request_type" class="form-control form-control-sm">
                        <option value="all">{{ __('realestate.all') }}</option>
                        <option value="rent" {{ request('request_type') == 'rent' ? 'selected' : '' }}>{{ __('realestate.for_rent') }}</option>
                        <option value="sale" {{ request('request_type') == 'sale' ? 'selected' : '' }}>{{ __('realestate.for_sale') }}</option>
                    </select>
                </div>

                <div class="col-md-2 mb-2">
                    <label class="form-label font-weight-bold text-muted font-12 mb-1">{{ __('realestate.city') }}</label>
                    <select name="city" class="form-control form-control-sm">
                        <option value="all">{{ __('realestate.all') }}</option>
                        @foreach($cities as $c)
                        <option value="{{ $c }}" {{ request('city') == $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-1 mb-2 d-flex">
                    <button type="submit" class="btn btn-primary btn-sm btn-block" title="{{ __('realestate.filter') }}">
                        <i class="fas fa-filter"></i>
                    </button>
                    @if(request()->hasAny(['search', 'status', 'unit_type_id', 'request_type', 'city']))
                    <a href="{{ route('property-requests.index') }}" class="btn btn-outline-secondary btn-sm ml-1" title="{{ __('realestate.cancel') }}">
                        <i class="fas fa-redo"></i>
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- جدول طلبات الانتظار -->
<div class="card shadow-sm border-0" style="border-radius: 10px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover text-center align-middle mb-0" style="width:100%">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>{{ __('realestate.client_name') }}</th>
                        <th>{{ __('realestate.direct_call') }}</th>
                        <th>{{ __('realestate.unit_type') }}</th>
                        <th>{{ __('realestate.location_and_budget') }}</th>
                        <th>{{ __('realestate.requested_rooms') }}</th>
                        <th>{{ __('realestate.matching_units') }}</th>
                        <th>{{ __('realestate.status') }}</th>
                        <th style="width: 140px;">{{ __('realestate.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $index => $req)
                    @php
                        $matchingCount = $req->matching_units_count;
                    @endphp
                    <tr>
                        <td class="text-muted font-weight-bold">{{ $requests->firstItem() + $index }}</td>
                        
                        <!-- اسم العميل -->
                        <td class="text-right">
                            <div class="font-weight-bold text-dark font-14">{{ $req->client_name }}</div>
                            @if($req->national_id)
                            <small class="text-muted d-block font-11">{{ $req->national_id }}</small>
                            @endif
                            <small class="text-secondary font-11">{{ $req->created_at->diffForHumans() }}</small>
                        </td>

                        <!-- أزرار الاتصال والواتساب -->
                        <td>
                            <div class="d-inline-flex align-items-center gap-1">
                                <a href="tel:{{ $req->client_phone }}" class="btn btn-sm btn-outline-primary btn-call-sm mr-1" title="{{ $req->client_phone }}">
                                    <i class="fas fa-phone-alt"></i>
                                </a>
                                @if($req->whatsapp_url)
                                <a href="{{ $req->whatsapp_url }}" target="_blank" class="btn btn-sm btn-whatsapp-sm" title="WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                @endif
                            </div>
                            <div class="font-11 text-muted mt-1" dir="ltr">{{ $req->client_phone }}</div>
                        </td>

                        <!-- نوع الطلب والعقار -->
                        <td>
                            <span class="badge {{ $req->request_type == 'rent' ? 'badge-primary' : 'badge-info' }} px-2 py-1 font-11" style="border-radius: 10px;">
                                {{ $req->request_type_label }}
                            </span>
                            <div class="font-weight-bold text-dark mt-1 font-13">
                                {{ $req->unitType->name ?? __('realestate.any_unit_type') }}
                            </div>
                        </td>

                        <!-- الموقع والميزانية -->
                        <td>
                            <div class="font-weight-bold text-secondary font-13">
                                {{ $req->city ?? '-' }}
                                @if($req->district)
                                 - {{ $req->district }}
                                @endif
                            </div>
                            <div class="font-12 text-dark font-weight-bold mt-1">
                                @if($req->max_price)
                                <span class="text-success">{{ number_format($req->max_price) }}</span> {{ __('realestate.sar') }}
                                @if($req->min_price)
                                <small class="text-muted font-11">({{ number_format($req->min_price) }})</small>
                                @endif
                                @else
                                <span class="text-muted font-11">{{ __('realestate.open_budget') }}</span>
                                @endif
                            </div>
                        </td>

                        <!-- المواصفات -->
                        <td class="font-12">
                            @if($req->rooms_count)
                            <span class="badge badge-light border text-dark mr-1"><i class="fas fa-bed text-primary mr-1"></i> {{ $req->rooms_count }}</span>
                            @endif
                            @if($req->bathrooms_count)
                            <span class="badge badge-light border text-dark"><i class="fas fa-bath text-info mr-1"></i> {{ $req->bathrooms_count }}</span>
                            @endif
                            @if(!$req->rooms_count && !$req->bathrooms_count)
                            <span class="text-muted">-</span>
                            @endif
                        </td>

                        <!-- المطابقة الآلية -->
                        <td>
                            @if($matchingCount > 0)
                            <a href="{{ route('property-requests.show', $req->id) }}#matching-section" class="badge badge-pill badge-success px-2 py-1 font-11 shadow-sm">
                                <i class="fas fa-check mr-1"></i> {{ $matchingCount }} {{ __('realestate.matching_units_count') }}
                            </a>
                            @else
                            <span class="badge badge-pill badge-light text-muted border px-2 py-1 font-11">
                                -
                            </span>
                            @endif
                        </td>

                        <!-- الحالة -->
                        <td>
                            <span class="badge badge-pill-custom {{ $req->status_badge_class }}">
                                {{ $req->status_label }}
                            </span>
                        </td>

                        <!-- العمليات -->
                        <td>
                            <div class="d-flex justify-content-center align-items-center">
                                <a href="{{ route('property-requests.show', $req->id) }}" class="btn btn-sm btn-info text-white mr-1" style="border-radius: 6px;" title="{{ __('realestate.show') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('property-requests.edit', $req->id) }}" class="btn btn-sm btn-primary mr-1" style="border-radius: 6px;" title="{{ __('realestate.edit') }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('property-requests.destroy', $req->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('realestate.confirm_delete_request') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" style="border-radius: 6px;" title="{{ __('realestate.delete') }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="py-5 text-muted">
                            <i class="fas fa-inbox fa-3x text-light mb-3 d-block"></i>
                            {{ __('realestate.no_data') }}
                            <div class="mt-2">
                                <a href="{{ route('property-requests.create') }}" class="btn btn-sm btn-primary" style="border-radius: 6px;">
                                    <i class="fas fa-plus-circle mr-1"></i> {{ __('realestate.add_property_request') }}
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($requests->hasPages())
    <div class="card-footer bg-white border-0 py-3">
        <div class="d-flex justify-content-center">
            {{ $requests->links() }}
        </div>
    </div>
    @endif
</div>

@endsection
