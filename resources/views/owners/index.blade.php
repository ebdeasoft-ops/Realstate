@extends('layouts.master')

@section('css')
<style>
    .table thead th { background-color: #f8f9fe; border-bottom: 2px solid #e1e5ef; color: #444; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .table tbody tr:hover { background-color: #f1f4f9; transition: 0.3s; }
    .btn-custom { border-radius: 8px; font-weight: 600; padding: 6px 15px; }
    .card-header-custom { background: #fff; border-bottom: 1px solid #eee; padding: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
</style>
@endsection

@section('title') 
{{ __('realestate.owners') }} 
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <h4 class="content-title mb-0">{{ __('realestate.owners') }}</h4>
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
                <h5 class="mb-0 text-primary"><i class="fas fa-users mr-2"></i> {{ __('realestate.owners') }}</h5>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('owners.create') }}" class="btn btn-primary btn-custom shadow-sm">
                        <i class="fas fa-plus"></i> {{ __('realestate.add_owner') }}
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover text-center" id="ownersTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('realestate.name') }}</th>
                                <th>{{ __('realestate.phone') }}</th>
                                <th>{{ __('realestate.bank_account') }}</th>
                                <th>{{ __('realestate.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($owners as $index => $owner)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $owner->name }}</td>
                                <td>{{ $owner->phone ?? '-' }}</td>
                                <td>{{ $owner->bank_account ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('owners.show', $owner->id) }}" class="btn btn-sm btn-info btn-custom">
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