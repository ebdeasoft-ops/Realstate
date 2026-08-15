@extends('layouts.master')

@section('title')
    {{ __('realestate.property_details') }}
@endsection

@section('content')
    <br>
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 text-primary"><i class="fas fa-building mr-2"></i> {{ $property->name }}</h5>
                    <div>
                        <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> {{ __('realestate.edit') }}
                        </a>
                        <a href="{{ route('properties.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-right"></i> {{ __('realestate.back') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    
                    <!-- معلومات العقار والمالك والبيانات البنكية الأساسية -->
                    <div class="row mb-4">
                        <!-- القسم الأول: معلومات العقار والمدينة -->
                        <div class="col-md-4 border-left">
                            <h6 class="text-primary font-weight-bold mb-3"><i class="fas fa-home ml-1"></i> {{ __('realestate.property_details') }}</h6>
                            <p><strong>{{ __('realestate.unit_type') }}:</strong> {{ __('realestate.unit_types_list')[$property->property_category] ?? $property->property_category }}</p>
                            <p><strong>{{ __('realestate.name') }}:</strong> {{ $property->name }}</p>
                            <p><strong>{{ __('realestate.status') ?? 'الحالة' }}:</strong> 
                                <span class="badge {{ $property->status == 'مفعل' ? 'bg-success' : 'bg-danger' }} text-white">
                                    {{ $property->status }}
                                </span>
                            </p>
                            <p><strong>{{ __('realestate.address') }}:</strong> {{ $property->address ?? '-' }}</p>
                            <p><strong>{{ __('realestate.city') }}:</strong> {{ $property->city }}</p>
                            <p><strong>{{ __('realestate.district') }}:</strong> {{ $property->district ?? '-' }}</p>
                            <p><strong>{{ __('realestate.product_notes') }}:</strong> {{ $property->description ?? '-' }}</p>
                        </div>

                        <!-- القسم الثاني: بيانات المالك التفصيلية -->
                        <div class="col-md-4 border-left">
                            <h6 class="text-primary font-weight-bold mb-3"><i class="fas fa-user ml-1"></i> {{ __('realestate.owner_name') }}</h6>
                            <p><strong>{{ __('realestate.owner_name') }}:</strong> {{ optional($property->owner)->name ?? '-' }}</p>
                            <p><strong>{{ __('realestate.owner_id_number') }}:</strong> {{ $property->owner_id_number ?? '-' }}</p>
                            <p><strong>{{ __('realestate.owner_nationality') }}:</strong> {{ $property->owner_nationality ?? '-' }}</p>
                            <p><strong>{{ __('realestate.owner_phone') }}:</strong> {{ $property->owner_phone ?? '-' }}</p>
                            <p><strong>{{ __('realestate.owner_landline') }}:</strong> {{ $property->owner_landline ?? '-' }}</p>
                            <p><strong>{{ __('realestate.owner_address') }}:</strong> {{ $property->owner_address ?? '-' }}</p>
                            <p><strong>{{ __('realestate.owner_email') }}:</strong> {{ $property->owner_email ?? '-' }}</p>
                        </div>

                        <!-- القسم الثالث: البيانات البنكية والمالية -->
                        <div class="col-md-4">
                            <h6 class="text-primary font-weight-bold mb-3"><i class="fas fa-university ml-1"></i> {{ __('realestate.financial_and_regulatory_data') }}</h6>
                            <p><strong>{{ __('realestate.bank_name') }}:</strong> {{ $property->bank_name ?? '-' }}</p>
                            <p><strong>{{ __('realestate.account_number') }}:</strong> {{ $property->account_number ?? '-' }}</p>
                            <p><strong>{{ __('realestate.iban') }}:</strong> {{ $property->iban ?? '-' }}</p>
                            <p><strong>{{ __('realestate.commission_rate') }}:</strong> {{ $property->commission_rate ?? '-' }}%</p>
                            <p><strong>{{ __('realestate.insurance_account') }}:</strong> {{ $property->insurance_account ?? '-' }}</p>
                            <p><strong>{{ __('realestate.water_account') }}:</strong> {{ $property->water_account ?? '-' }}</p>
                        </div>
                    </div>

                    <hr>

                    <!-- قسم عرض المرفقات -->
                    <h5 class="mb-3 text-secondary"><i class="fas fa-images mr-2"></i> {{ __('realestate.media') }}</h5>
                    <div class="row mb-4">
                        @if(isset($property->media) && count($property->media) > 0)
                            @foreach($property->media as $media)
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100 shadow-sm">
                                        @if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $media->file_path))
                                            <img src="{{ asset('storage/' . $media->file_path) }}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                        @else
                                            <video class="card-img-top" style="height: 150px; object-fit: cover;" controls>
                                                <source src="{{ asset('storage/' . $media->file_path) }}">
                                            </video>
                                        @endif
                                        <div class="card-footer bg-white text-center">
                                            <a href="{{ asset('storage/' . $media->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">عرض الملف</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12"><p class="text-muted">{{ __('realestate.no_attachments') }}</p></div>
                        @endif
                    </div>

                    <hr>

                    <!-- قسم الوحدات -->
                    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                        <h5 class="text-secondary mb-0"><i class="fas fa-door-open mr-2"></i> {{ __('realestate.units') }}</h5>
                        <a href="{{ route('units.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> {{ __('realestate.add_unit') }}</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center align-middle">
                            <thead class="thead-light bg-light">
                                <tr>
                                    <th>{{ __('realestate.unit_number') }}</th>
                                    <th>اسم المستأجر الحالي</th>
                                    <th>{{ __('realestate.annual_rent') }}</th>
                                    <th>{{ __('realestate.electricity_meter') }}</th>
                                    <th>{{ __('realestate.water_meter') }}</th>
                                    <th>{{ __('realestate.ac_count') }}</th>
                                    <th>{{ __('realestate.status') }}</th>
                                    <th>{{ __('realestate.attachments') }}</th>
                                    <th>{{ __('realestate.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($property->units ?? [] as $unit)
                                    @php
                                        // جلب العقد النشط والمستأجر المرتبط بالوحدة
                                        $activeContract = ($unit->is_rented == 1 || $unit->status == 'rented') ? $unit->activeContract()->with('tenant')->first() : null;
                                        $tenantName = optional(optional($activeContract)->tenant)->name ?? '-';
                                    @endphp
                                    <tr>
                                        <td class="font-weight-bold">{{ $unit->unit_name ?? $unit->unit_number }}</td>
                                        <td class="text-primary font-weight-bold">{{ $tenantName }}</td>
                                        <td>{{ number_format($unit->annual_rent, 2) }}</td>
                                        <td>{{ $unit->electricity_meter ?? '-' }}</td>
                                        <td>{{ $unit->water_meter ?? '-' }}</td>
                                        <td><span class="badge bg-secondary text-white">{{ $unit->ac_count ?? 0 }}</span></td>
                                        <td>
                                            <span class="badge {{ $unit->is_rented == 1 ? 'bg-danger' : 'bg-success' }} text-white">
                                                {{ $unit->is_rented == 1 ? __('realestate.rented') : __('realestate.vacant') }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($unit->images && count($unit->images) > 0)
                                                <button type="button" class="btn btn-sm btn-info text-white" data-toggle="modal" data-target="#unitMediaModal{{ $unit->id }}">
                                                    <i class="fas fa-images"></i> ({{ count($unit->images) }})
                                                </button>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('units.show', $unit->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="9" class="text-muted py-4">{{ __('realestate.no_units') }}</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals مرفقات الوحدات -->
    @foreach($property->units ?? [] as $unit)
        @if($unit->images && count($unit->images) > 0)
            <div class="modal fade" id="unitMediaModal{{ $unit->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header"><h5 class="modal-title">{{ __('realestate.unit_number') }}: {{ $unit->unit_number }}</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button></div>
                        <div class="modal-body"><div class="row">
                            @foreach($unit->images as $img)
                                <div class="col-md-4 mb-3 text-center">
                                    <img src="{{ asset('storage/' . $img->file_path) }}" class="img-fluid rounded shadow-sm" style="height: 180px; width: 100%; object-fit: cover;">
                                </div>
                            @endforeach
                        </div></div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection