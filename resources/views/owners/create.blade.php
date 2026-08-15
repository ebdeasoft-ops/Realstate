@extends('layouts.master')

@section('css')
<style>
    .card-header-custom { background: #fff; border-bottom: 1px solid #eee; padding: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
    .btn-custom { border-radius: 8px; font-weight: 600; padding: 6px 15px; }
</style>
@endsection

@section('title') 
{{ __('realestate.add_owner') }} 
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
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <!-- Header -->
            <div class="card-header-custom">
                <h5 class="mb-0 text-primary"><i class="fas fa-user-plus mr-2"></i> {{ __('realestate.add_owner') }}</h5>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('owners.index') }}" class="btn btn-secondary btn-custom shadow-sm">
                        <i class="fas fa-arrow-right"></i> {{ __('realestate.back') ?? 'رجوع' }}
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('owners.store') }}" method="POST" autocomplete="off">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('realestate.name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('realestate.phone') }}</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('realestate.bank_account') }}</label>
                        <input type="text" name="bank_account" class="form-control" value="{{ old('bank_account') }}">
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-custom px-4 shadow-sm">
                            <i class="fas fa-save"></i> {{ __('realestate.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection