@extends('layouts.master')

@section('css')
<style>
    .table thead th { background-color: #f8f9fe; border-bottom: 2px solid #e1e5ef; color: #444; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .table tbody tr:hover { background-color: #f1f4f9; transition: 0.3s; }
    .badge { padding: 8px 12px; border-radius: 50px; font-size: 12px; }
    .btn-custom { border-radius: 8px; font-weight: 600; padding: 6px 15px; }
    .card-header-custom { background: #fff; border-bottom: 1px solid #eee; padding: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
</style>
@endsection

@section('title') 
{{ __('realestate.properties') }} 
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <h4 class="content-title mb-0">{{ __('realestate.properties') }}</h4>
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
            <div class="card-header-custom">
                <h5 class="mb-0 text-primary"><i class="fas fa-building mr-2"></i> {{ __('realestate.properties') }}</h5>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('properties.create') }}" class="btn btn-primary btn-custom shadow-sm">
                        <i class="fas fa-plus"></i> {{ __('realestate.add_property') }}
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-center" id="propertiesTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('realestate.name') }}</th>
                                <th>{{ __('realestate.owner_name') }}</th>
                                <th>{{ __('realestate.city') }}</th>
                                <th>{{ __('realestate.type') }}</th>
                                <th>{{ __('realestate.annual_rent') }}</th>
                                <th>{{ __('realestate.total_unit') }}</th>
                                <th>{{ __('realestate.vacant') }}</th>
                                <th>{{ __('realestate.rented') }}</th>
                                <th>{{ __('realestate.commission_rate') }}</th>
                                <th>{{ __('realestate.attachments') }}</th>
                                <th>{{ __('realestate.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($properties as $index => $property)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="font-weight-bold">{{ $property->name }}</td>
                                <td>{{ $property->owner->name ?? '-' }}</td>
                                <td>{{ $property->city }} - {{ $property->district }}</td>
                                <td>
                                    @if($property->type == 'sale')
                                        <span class="badge bg-success text-white">{{ __('realestate.sale') }}</span>
                                    @else
                                        <span class="badge bg-info text-white">{{ __('realestate.rent') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($property->type == 'sale')
                                        <span class="text-success font-weight-bold">{{ number_format($property->sale_price, 2) }}</span>
                                    @else
                                        <span class="text-primary font-weight-bold">{{ number_format($property->annual_rent, 2) }} / {{ __('realestate.year') }}</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-secondary text-white">{{ $property->units->count() }}</span></td>
                                <td><span class="badge bg-success text-white">{{ $property->units->where('is_rented', 0)->count() }}</span></td>
                                <td><span class="badge bg-danger text-white">{{ $property->units->where('is_rented', 1)->count() }}</span></td>
                                
                                <td>{{ $property->commission_rate ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('properties.show', $property->id) }}" class="btn btn-sm btn-secondary btn-custom" title="Files">
                                        <i class="fas fa-paperclip"></i> {{ __('realestate.attachments') }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('properties.show', $property->id) }}" class="btn btn-sm btn-info btn-custom" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection