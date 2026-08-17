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
                        <i class="fas fa-arrow-right"></i> {{ __('realestate.back') }}
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('owners.store') }}" method="POST" autocomplete="off">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('realestate.owner_name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('realestate.owner_phone') }}</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('realestate.owner_address') }}</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('realestate.owner_nationality') }}</label>
                        <input type="text" name="nationality" class="form-control" value="{{ old('nationality') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('realestate.owner_id_number') }}</label>
                        <input type="text" name="national_id" class="form-control" value="{{ old('national_id') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('realestate.bank_name') }}</label>
                        <select name="bank_name" class="form-control">
                            <option value="">{{ __('realestate.choose_status') ?? 'اختر البنك...' }}</option>
                            @foreach(__('realestate.saudi_banks_list') as $key => $bankName)
                                <option value="{{ $key }}" {{ old('bank_name') == $key ? 'selected' : '' }}>
                                    {{ $bankName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('realestate.bank_account') }}</label>
                        <input type="text" name="bank_account_number" class="form-control" value="{{ old('bank_account_number') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label font-weight-bold">{{ __('realestate.iban') }}</label>
                        <input type="text" name="iban" class="form-control" value="{{ old('iban') }}">
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