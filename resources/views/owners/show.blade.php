@extends('layouts.master')

@section('title')
    {{ __('realestate.details') }} - {{ $owner->name ?? '-' }}
@endsection

@section('css')
<style>
    .property-header { background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px; padding: 25px; border: 1px solid rgba(0,0,0,0.05); }
    .table thead th { background-color: #f1f4f9; color: #333; font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; white-space: nowrap; }
    .badge-custom { padding: 5px 10px; border-radius: 50px; font-weight: 600; font-size: 0.75rem; }
    .property-card { border: 1px solid #e3e6f0; border-radius: 10px; margin-bottom: 20px; overflow: hidden; background: #fff; }
    .property-title-bar { background-color: #f8f9fc; padding: 12px 20px; border-bottom: 1px solid #e3e6f0; font-weight: bold; }
    .table td { font-size: 0.85rem; vertical-align: middle; }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <!-- رأس الصفحة لمعلومات المالك -->
            <div class="card shadow-sm border-0 mb-4 property-header">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h3 class="mb-1 text-primary font-weight-bold">
                            <i class="fas fa-user-tie mr-2"></i> {{ $owner->name ?? '-' }}
                        </h3>
                        <p class="text-muted mb-0">
                            <i class="fas fa-phone mr-1"></i> <span dir="ltr">{{ $owner->phone ?? '-' }}</span> | <i class="fas fa-envelope mr-1"></i> {{ $owner->email ?? '-' }}
                        </p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('owners.edit', $owner->id) }}" class="btn btn-primary btn-sm px-3 py-2 shadow-sm">
                            <i class="fas fa-edit mr-1"></i> {{ __('realestate.edit') }}
                        </a>
                        <a href="{{ route('owners.index') }}" class="btn btn-secondary btn-sm px-3 py-2 shadow-sm">
                            <i class="fas fa-arrow-right mr-1"></i> {{ __('realestate.back') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- قائمة العمارات/العقارات وتحت كل عقار وحداته وبياناتها الكاملة -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-secondary font-weight-bold">
                        <i class="fas fa-building mr-2 text-primary"></i> {{ __('realestate.properties') }} {{ __('realestate.units') }}
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($owner->properties ?? [] as $property)
                        <div class="property-card shadow-sm mb-4">
                            <!-- عنوان العقار (العمارة) -->
                            <div class="property-title-bar d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div>
                                    <i class="fas fa-city text-primary mr-2"></i> 
                                    <span class="text-dark font-weight-bold" style="font-size: 1.1rem;">{{ $property->name }}</span>
                                    <span class="text-muted small mr-3">({{ $property->city }} - {{ $property->district ?? '' }})</span>
                                </div>
                                <a href="{{ route('properties.show', $property->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> {{ __('realestate.view') }}
                                </a>
                            </div>

                            <!-- جدول الوحدات التفصيلي -->
                            <div class="table-responsive p-2">
                                <table class="table table-hover text-center align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('realestate.unit_number') }}</th>
                                            <th>{{ __('realestate.unit_type') }}</th>
                                            <th>{{ __('realestate.floor_number') }}</th>
                                            <th>{{ __('realestate.rooms_count') }}</th>
                                            <th>{{ __('realestate.kitchens_count') }}</th>
                                            <th>{{ __('realestate.bathrooms_count') }}</th>
                                            <th>{{ __('realestate.ac_status') }}</th>
                                            <th>{{ __('realestate.electricity_meter') }}</th>
                                            <th>{{ __('realestate.water_meter') }}</th>
                                            <th>{{ __('realestate.annual_rent') }}</th>
                                            <th>{{ __('realestate.status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($property->units ?? [] as $unit)
                                            <tr>
                                                <td class="font-weight-bold text-dark">{{ $unit->unit_number ?? '-' }}</td>
                                                <td>{{ $unit->unit_category ?? '-' }}</td>
                                                <td>{{ $unit->floor_number ?? '-' }}</td>
                                                <td><span class="badge bg-light text-dark border">{{ $unit->rooms_count ?? 0 }}</span></td>
                                                <td><span class="badge bg-light text-dark border">{{ $unit->kitchens_count ?? 0 }}</span></td>
                                                <td><span class="badge bg-light text-dark border">{{ $unit->bathrooms_count ?? 0 }}</span></td>
                                                <td class="text-muted" style="max-width: 150px;" title="{{ $unit->ac_status }}">{{ $unit->ac_status ?? '-' }}</td>
                                                <td>{{ $unit->electricity_meter ?? '-' }}</td>
                                                <td>{{ $unit->water_meter ?? '-' }}</td>
                                                <td class="font-weight-bold text-success">{{ number_format($unit->annual_rent ?? 0, 2) }} {{ __('realestate.sar') }}</td>
                                                <td>
                                                    <span class="badge-custom {{ ($unit->is_rented ?? 0) == 1 ? 'bg-danger' : 'bg-success' }} text-white">
                                                        {{ ($unit->is_rented ?? 0) == 1 ? __('realestate.rented') : __('realestate.vacant') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="text-muted py-3">
                                                    {{ __('realestate.no_units') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-folder-open fa-3x mb-3 text-black-50 d-block"></i>
                            {{ __('realestate.no_units_found') }}
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection