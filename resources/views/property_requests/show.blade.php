@extends('layouts.master')

@section('title')
{{ __('realestate.request_details') }} #{{ $propertyRequest->id }}
@endsection

@section('css')
<style>
    .detail-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .client-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0162e8 0%, #014bb1 100%);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    }
    .spec-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 12px;
    }
    .spec-label {
        font-size: 0.78rem;
        color: #64748b;
        font-weight: 700;
        margin-bottom: 4px;
        text-transform: uppercase;
    }
    .spec-value {
        font-size: 0.95rem;
        color: #1e293b;
        font-weight: 700;
    }
    .btn-whatsapp-lg {
        background-color: #25D366;
        color: #fff !important;
        font-weight: 700;
        border: none;
        border-radius: 6px;
        padding: 9px 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .btn-whatsapp-lg:hover {
        background-color: #1ebc59;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
    }
    .btn-call-lg {
        background-color: #0162e8;
        color: #fff !important;
        font-weight: 700;
        border-radius: 6px;
        padding: 9px 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .btn-call-lg:hover {
        background-color: #0152c2;
    }
    .matching-card {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        transition: all 0.2s ease;
    }
    .matching-card:hover {
        border-color: #10b981;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.12);
    }
    .badge-pill-custom {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 700;
    }
</style>
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between mb-3">
    <div>
        <h4 class="content-title mb-1 text-primary font-weight-bold">
            <i class="fas fa-file-alt mr-2"></i> {{ __('realestate.request_details') }} #{{ $propertyRequest->id }}
        </h4>
        <p class="text-muted mb-0 font-13">{{ $propertyRequest->created_at->format('Y-m-d H:i') }}</p>
    </div>
    <div class="d-flex align-items-center">
        <a href="{{ route('property-requests.edit', $propertyRequest->id) }}" class="btn btn-primary btn-sm mr-2 shadow-sm" style="border-radius: 6px; padding: 7px 18px;">
            <i class="fas fa-edit mr-1"></i> {{ __('realestate.edit') }}
        </a>
        <a href="{{ route('property-requests.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm" style="border-radius: 6px; padding: 7px 18px;">
            <i class="fas fa-arrow-right mr-1"></i> {{ __('realestate.back') }}
        </a>
    </div>
</div>
@endsection

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-lg mb-4" role="alert">
    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="row">
    <!-- كارت بيانات العميل والتواصل -->
    <div class="col-lg-4 mb-4">
        <div class="card detail-card mb-4">
            <div class="card-body p-4 text-center">
                <div class="client-avatar mx-auto mb-3 shadow-sm">
                    <i class="fas fa-user"></i>
                </div>
                <h5 class="font-weight-bold text-dark mb-1">{{ $propertyRequest->client_name }}</h5>
                <p class="text-muted font-14 mb-3" dir="ltr"><i class="fas fa-phone-alt mr-1"></i> {{ $propertyRequest->client_phone }}</p>

                <!-- شارة الحالة -->
                <div class="mb-4">
                    <span class="badge badge-pill-custom {{ $propertyRequest->status_badge_class }} shadow-sm">
                        {{ $propertyRequest->status_label }}
                    </span>
                </div>

                <!-- أزرار الاتصال والواتساب -->
                <div class="d-grid gap-2 mb-3">
                    <a href="tel:{{ $propertyRequest->client_phone }}" class="btn btn-call-lg btn-block shadow-sm mb-2">
                        <i class="fas fa-phone-alt"></i> {{ __('realestate.direct_call') }}
                    </a>

                    @if($propertyRequest->whatsapp_url)
                    <a href="{{ $propertyRequest->whatsapp_url }}" target="_blank" class="btn btn-whatsapp-lg btn-block shadow-sm">
                        <i class="fab fa-whatsapp font-16"></i> {{ __('realestate.whatsapp_chat') }}
                    </a>
                    @endif
                </div>

                <hr class="my-3">

                <!-- تفاصيل إضافية -->
                <div class="text-right font-13">
                    @if($propertyRequest->national_id)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ __('realestate.national_id_or_iqama') }}:</span>
                        <span class="font-weight-bold text-dark">{{ $propertyRequest->national_id }}</span>
                    </div>
                    @endif

                    @if($propertyRequest->client_email)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ __('realestate.email_address') }}:</span>
                        <span class="font-weight-bold text-dark">{{ $propertyRequest->client_email }}</span>
                    </div>
                    @endif

                    @if($propertyRequest->customer)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ __('realestate.client_name') }}:</span>
                        <a href="{{ url('getcustomer/' . $propertyRequest->customer_id) }}" class="font-weight-bold text-primary">
                            {{ __('realestate.view') }}
                        </a>
                    </div>
                    @endif

                    @if($propertyRequest->creator)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ __('realestate.owner') }}:</span>
                        <span class="font-weight-bold text-dark">{{ $propertyRequest->creator->name }}</span>
                    </div>
                    @endif

                    @if($propertyRequest->last_contacted_at)
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">{{ __('realestate.status_contacted') }}:</span>
                        <span class="font-weight-bold text-info">{{ $propertyRequest->last_contacted_at->format('Y-m-d H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- تحديث الحالة والمتابعة -->
        <div class="card detail-card mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="font-weight-bold text-primary mb-0 font-14">
                    <i class="fas fa-tasks mr-2"></i> {{ __('realestate.change_status') }}
                </h6>
            </div>
            <div class="card-body p-3">
                <form action="{{ route('property-requests.update-status', $propertyRequest->id) }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label font-weight-bold font-12">{{ __('realestate.request_status') }}:</label>
                        <select name="status" class="form-control" style="height: 38px; font-size: 0.85rem;" required>
                            <option value="pending" {{ $propertyRequest->status == 'pending' ? 'selected' : '' }}>{{ __('realestate.status_pending') }}</option>
                            <option value="contacted" {{ $propertyRequest->status == 'contacted' ? 'selected' : '' }}>{{ __('realestate.status_contacted') }}</option>
                            <option value="fulfilled" {{ $propertyRequest->status == 'fulfilled' ? 'selected' : '' }}>{{ __('realestate.status_fulfilled') }}</option>
                            <option value="cancelled" {{ $propertyRequest->status == 'cancelled' ? 'selected' : '' }}>{{ __('realestate.status_cancelled') }}</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label font-weight-bold font-12">{{ __('realestate.add_contact_note') }}:</label>
                        <textarea name="contact_notes" class="form-control" rows="2" placeholder="{{ __('realestate.contact_note_placeholder') }}"></textarea>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary btn-block" style="border-radius: 6px; padding: 8px;">
                        <i class="fas fa-save mr-1"></i> {{ __('realestate.save_status') }}
                    </button>
                </form>

                @if($propertyRequest->contact_notes)
                <div class="mt-3 pt-3 border-top">
                    <label class="font-weight-bold text-muted font-11 text-uppercase mb-1">{{ __('realestate.contact_history') }}:</label>
                    <div class="p-2 bg-light rounded font-12 text-muted" style="white-space: pre-line; max-height: 140px; overflow-y: auto; line-height: 1.6;">
{{ $propertyRequest->contact_notes }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- المواصفات والمطابقة -->
    <div class="col-lg-8 mb-4">
        <!-- كارت المواصفات المطلوبة -->
        <div class="card detail-card mb-4">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h6 class="font-weight-bold text-primary mb-0 font-14">
                    <i class="fas fa-list-check mr-2"></i> {{ __('realestate.specifications_and_amenities') }}
                </h6>
                <span class="badge {{ $propertyRequest->request_type == 'rent' ? 'badge-primary' : 'badge-info' }} px-3 py-1 font-12" style="border-radius: 12px;">
                    {{ $propertyRequest->request_type_label }}
                </span>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="spec-item">
                            <div class="spec-label">{{ __('realestate.unit_type_required') }}</div>
                            <div class="spec-value text-primary">{{ $propertyRequest->unitType->name ?? __('realestate.any_unit_type') }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="spec-item">
                            <div class="spec-label">{{ __('realestate.target_city') }}</div>
                            <div class="spec-value">{{ $propertyRequest->city ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="spec-item">
                            <div class="spec-label">{{ __('realestate.target_district') }}</div>
                            <div class="spec-value">{{ $propertyRequest->district ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="spec-item">
                            <div class="spec-label">{{ __('realestate.budget_range') }}</div>
                            <div class="spec-value text-success">
                                @if($propertyRequest->max_price)
                                    {{ number_format($propertyRequest->max_price) }} {{ __('realestate.sar') }}
                                    @if($propertyRequest->min_price)
                                    <small class="text-muted font-11 d-block">({{ number_format($propertyRequest->min_price) }} - {{ number_format($propertyRequest->max_price) }})</small>
                                    @endif
                                @else
                                    <span class="text-muted">{{ __('realestate.open_budget') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="spec-item">
                            <div class="spec-label">{{ __('realestate.requested_rooms') }}</div>
                            <div class="spec-value">{{ $propertyRequest->rooms_count ? $propertyRequest->rooms_count : '-' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="spec-item">
                            <div class="spec-label">{{ __('realestate.requested_bathrooms') }}</div>
                            <div class="spec-value">{{ $propertyRequest->bathrooms_count ? $propertyRequest->bathrooms_count : '-' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="spec-item">
                            <div class="spec-label">{{ __('realestate.preferred_floor') }}</div>
                            <div class="spec-value">{{ $propertyRequest->floor_number ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="spec-item">
                            <div class="spec-label">{{ __('realestate.preferred_finishing') }}</div>
                            <div class="spec-value">{{ $propertyRequest->finishing_type ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="spec-item">
                            <div class="spec-label">{{ __('realestate.preferred_ac') }}</div>
                            <div class="spec-value">{{ $propertyRequest->ac_status ?? '-' }}</div>
                        </div>
                    </div>
                </div>

                @if($propertyRequest->notes)
                <div class="p-3 bg-light rounded mt-2 border">
                    <strong class="text-dark font-13 d-block mb-1"><i class="fas fa-comment-dots text-secondary mr-1"></i> {{ __('realestate.client_notes') }}:</strong>
                    <p class="mb-0 text-muted font-13">{{ $propertyRequest->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- قسم محرك المطابقة: الوحدات المتوفرة -->
        <div class="card detail-card" id="matching-section">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h6 class="font-weight-bold text-success mb-0 font-14">
                        <i class="fas fa-check-double mr-2"></i> {{ __('realestate.matching_units') }}
                    </h6>
                </div>
                <div>
                    <span class="badge badge-pill badge-success font-12 px-3 py-1 shadow-sm">
                        {{ $matchingUnits->count() }} {{ __('realestate.matching_units_count') }}
                    </span>
                </div>
            </div>

            <div class="card-body p-4">
                @if($matchingUnits->count() > 0)
                <div class="row">
                    @foreach($matchingUnits as $unit)
                    <div class="col-md-6 mb-3">
                        <div class="card matching-card shadow-sm h-100">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="font-weight-bold text-primary mb-1">
                                            <i class="fas fa-door-open mr-1"></i> {{ __('realestate.unit_number') }}: {{ $unit->unit_number }}
                                        </h6>
                                        <div class="text-muted font-12">
                                            <i class="fas fa-building mr-1"></i> {{ $unit->property->name ?? '-' }}
                                        </div>
                                    </div>
                                    <span class="badge badge-success px-2 py-1 font-11">{{ __('realestate.vacant') }}</span>
                                </div>

                                <div class="p-2 bg-light rounded mb-2 font-12">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted"><i class="fas fa-map-marker-alt text-danger mr-1"></i> {{ __('realestate.city') }}:</span>
                                        <span class="font-weight-bold">{{ $unit->property->city ?? '-' }} - {{ $unit->property->district ?? '-' }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted"><i class="fas fa-money-bill-wave text-success mr-1"></i> {{ __('realestate.annual_rent') }}:</span>
                                        <span class="font-weight-bold text-success">{{ number_format($unit->annual_rent, 2) }} {{ __('realestate.sar') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted"><i class="fas fa-bed text-info mr-1"></i> {{ __('realestate.rooms_count') }}:</span>
                                        <span class="font-weight-bold">{{ $unit->rooms_count ?? '-' }} {{ __('realestate.requested_rooms') }} / {{ $unit->bathrooms_count ?? '-' }} {{ __('realestate.requested_bathrooms') }}</span>
                                    </div>
                                    @if($unit->floor_number)
                                    <div class="d-flex justify-content-between mt-1">
                                        <span class="text-muted"><i class="fas fa-layer-group text-secondary mr-1"></i> {{ __('realestate.floor_number') }}:</span>
                                        <span class="font-weight-bold">{{ $unit->floor_number }}</span>
                                    </div>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                                    <a href="{{ route('units.show', $unit->id) }}" target="_blank" class="btn btn-sm btn-outline-info" style="border-radius: 6px;" title="{{ __('realestate.show') }}">
                                        <i class="fas fa-external-link-alt mr-1"></i> {{ __('realestate.show') }}
                                    </a>

                                    <form action="{{ route('property-requests.fulfill', $propertyRequest->id) }}" method="POST" onsubmit="return confirm('{{ __('realestate.confirm_fulfill') }}');">
                                        @csrf
                                        <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                                        <button type="submit" class="btn btn-sm btn-success shadow-sm" style="border-radius: 6px;">
                                            <i class="fas fa-key mr-1"></i> {{ __('realestate.mark_as_fulfilled') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-search-location fa-3x text-light mb-3 d-block"></i>
                    <h6 class="font-weight-bold text-secondary">{{ __('realestate.no_matching_units') }}</h6>
                    <p class="font-13 text-muted max-w-500 mx-auto">
                        {{ __('realestate.no_matching_units_desc') }}
                    </p>
                    <a href="{{ route('units.index') }}" class="btn btn-sm btn-outline-primary mt-2" style="border-radius: 6px;">
                        <i class="fas fa-door-open mr-1"></i> {{ __('realestate.units') }}
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
