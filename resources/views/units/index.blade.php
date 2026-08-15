@extends('layouts.master')

@section('css')
<style>
    .table thead th { background-color: #f8f9fe; border-bottom: 2px solid #e1e5ef; color: #444; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .table tbody tr:hover { background-color: #f1f4f9; transition: 0.3s; }
    .badge { padding: 6px 12px; border-radius: 50px; font-size: 12px; }
    .btn-custom { border-radius: 8px; font-weight: 600; padding: 6px 12px; }
    .card-header-custom { background: #fff; border-bottom: 1px solid #eee; padding: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
</style>
@endsection

@section('title') 
{{ __('realestate.units') }} 
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <h4 class="content-title mb-0">{{ __('realestate.units') }}</h4>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <!-- Header -->
            <div class="card-header-custom">
                <h5 class="mb-0 text-primary"><i class="fas fa-door-open mr-2"></i> {{ __('realestate.units') }}</h5>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('units.create') }}" class="btn btn-primary btn-custom shadow-sm">
                        <i class="fas fa-plus"></i> {{ __('realestate.add_unit') }}
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle" id="unitsTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('realestate.unit_number') }}</th>
                                <th>{{ __('realestate.current_tenant') ?? 'اسم المستأجر الحالي' }}</th>
                                <th>{{ __('realestate.rental_status') ?? 'حالة التأجير' }}</th>
                                <th>{{ __('realestate.properties') }}</th>
                                <th>{{ __('realestate.annual_rent') }}</th>
                                <th>{{ __('realestate.status') }}</th>
                                <th>{{ __('realestate.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($units as $index => $unit)
                            @php
                                $activeContract = ($unit->is_rented == 1) ? $unit->activeContract()->with('tenant')->first() : null;
                                $tenantName = optional(optional($activeContract)->tenant)->name ?? '-';
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="font-weight-bold">{{ $unit->unit_number }}</td>
                                <td class="text-primary font-weight-bold">{{ $tenantName }}</td>
                                
                                <td>
                                    @if($unit->is_rented == 1)
                                        <span class="text-danger font-weight-bold">{{ __('realestate.rented_yes') ?? 'مؤجر (نعم)' }}</span>
                                    @else
                                        <span class="text-success font-weight-bold">{{ __('realestate.vacant_no') ?? 'شاغر (لا)' }}</span>
                                    @endif
                                </td>

                                <td>{{ $unit->property->name ?? '-' }}</td>
                                <td>{{ number_format($unit->annual_rent, 2) }} {{ __('realestate.sar') }}</td>
                                <td>
                                    @if($unit->is_rented == 1)
                                        <span class="badge bg-danger text-white">{{ __('realestate.rented') ?? 'مؤجرة' }}</span>
                                    @else
                                        <span class="badge bg-success text-white">{{ __('realestate.vacant') ?? 'شاغرة' }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <!-- زر العرض -->
                                        <a href="{{ route('units.show', $unit->id) }}" class="btn btn-sm btn-info btn-custom text-white" title="{{ __('realestate.show') }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <!-- زر التعديل -->
                                        <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-sm btn-primary btn-custom" title="{{ __('realestate.edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <!-- زر الحذف -->
                                        <form action="{{ route('units.destroy', $unit->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('realestate.confirm_delete') ?? 'هل أنت متأكد من الحذف؟' }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-custom" title="{{ __('realestate.delete') }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-muted py-4">{{ __('realestate.no_units_found') ?? 'لا توجد وحدات مضافة حالياً' }}</td>
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