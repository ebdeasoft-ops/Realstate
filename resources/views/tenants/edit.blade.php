@extends('layouts.master')

@section('css')
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('title')
    {{ __('realestate.edit_tenant') ?? 'تعديل بيانات المستأجر' }}
@endsection

@section('page-header')
    <div class="main-parent">
        <div class="breadcrumb-header justify-content-between parent-heading">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto"><i class="fas fa-user-edit text-primary ml-2"></i> {{ __('realestate.edit_tenant') ?? 'تعديل بيانات المستأجر' }}: {{ $tenant->name }}</h4>
                </div>
            </div>
        </div>
    </div> 
@endsection

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong><i class="fas fa-exclamation-triangle ml-1"></i> خطأ</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card shadow-sm border-0 pt-4" style="border-radius: 12px;">
                <div class="card-body pb-0">
                    <form action="{{ route('tenants.update', $tenant->id) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('PUT')
                        
                        {{-- القسم الأول: البيانات الأساسية للمستأجر --}}
                        <div class="card bg-light border-0 mb-4 p-3" style="border-radius: 8px;">
                            <h5 class="text-primary mb-3 font-weight-bold" style="font-size: 15px;">
                                <i class="fas fa-id-card ml-1"></i> البيانات الأساسية
                            </h5>
                            <div class="row">
                                <div class="col-lg-4 mb-3">
                                    <label for="name" class="control-label parent-label">{{ __('realestate.tenant_name') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="name" name="name" value="{{ old('name', $tenant->name) }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-3 mb-3">
                                    <label for="phone" class="control-label parent-label">{{ __('realestate.phone') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-phone-alt"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="phone" name="phone" value="{{ old('phone', $tenant->phone) }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-3 mb-3">
                                    <label for="email" class="control-label parent-label">{{ __('realestate.email') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                                        <input type="email" class="form-control parent-input" id="email" name="email" value="{{ old('email', $tenant->email) }}">
                                    </div>
                                </div>

                                <div class="col-lg-2 mb-3">
                                    <label for="Balance" class="control-label parent-label">{{ __('realestate.current_balance') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-wallet"></i></span></div>
                                        <input type="number" step="0.01" class="parent-input form-control" id="Balance" name="Balance" value="{{ old('Balance', $tenant->Balance) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- القسم الثاني: البيانات المالية والتنظيمية --}}
                        <div class="card bg-light border-0 mb-4 p-3" style="border-radius: 8px;">
                            <h5 class="text-primary mb-3 font-weight-bold" style="font-size: 15px;">
                                <i class="fas fa-file-invoice-dollar ml-1"></i> البيانات المالية والتنظيمية
                            </h5>
                            <div class="row">
                                <div class="col-lg-3 mb-3">
                                    <label for="grace_period_in_days" class="control-label parent-label">{{ __('realestate.timeout_period') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                                        <input type="number" class="form-control parent-input" id="grace_period_in_days" name="grace_period_in_days" value="{{ old('grace_period_in_days', $tenant->grace_period_in_days) }}">
                                    </div>
                                </div>

                                <div class="col-lg-3 mb-3">
                                    <label for="tax_no" class="control-label parent-label">{{ __('realestate.tax_number') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-receipt"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="tax_no" name="tax_no" maxlength="15" minlength="15" value="{{ old('tax_no', $tenant->tax_no) }}">
                                    </div>
                                </div>

                                <div class="col-lg-2 mb-3">
                                    <label for="CRN" class="control-label parent-label">{{ __('realestate.crn') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-certificate"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="CRN" name="CRN" value="{{ old('CRN', $tenant->CRN) }}">
                                    </div>
                                </div>

                                <div class="col-lg-2 mb-3">
                                    <label for="Limit_credit" class="control-label parent-label">{{ __('realestate.credit_limit') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span></div>
                                        <input type="number" class="form-control parent-input" id="Limit_credit" name="Limit_credit" value="{{ old('Limit_credit', $tenant->Limit_credit) }}">
                                    </div>
                                </div>

                                <div class="col-lg-2 mb-3">
                                    <label for="address" class="control-label parent-label">{{ __('realestate.city') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-city"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="address" name="address" value="{{ old('address', $tenant->address) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- القسم الثالث: تفاصيل العنوان الوطني والملاحظات والهوية --}}
                        <div class="card bg-light border-0 mb-4 p-3" style="border-radius: 8px;">
                            <h5 class="text-primary mb-3 font-weight-bold" style="font-size: 15px;">
                                <i class="fas fa-map-marked-alt ml-1"></i> العنوان الوطني والملاحظات والهوية
                            </h5>
                            <div class="row">
                                <div class="col-lg-2 mb-3">
                                    <label for="sub_city" class="control-label parent-label">{{ __('realestate.region') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-map"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="sub_city" name="sub_city" value="{{ old('sub_city', $tenant->sub_city) }}">
                                    </div>
                                </div>
                                
                                <div class="col-lg-2 mb-3">
                                    <label for="street_name" class="control-label parent-label">{{ __('realestate.street_name') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-road"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="street_name" name="street_name" value="{{ old('street_name', $tenant->street_name) }}">
                                    </div>
                                </div>

                                <div class="col-lg-2 mb-3">
                                    <label for="plot_identification" class="control-label parent-label">{{ __('realestate.plot_identification') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-vector-square"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="plot_identification" name="plot_identification" value="{{ old('plot_identification', $tenant->plot_identification) }}">
                                    </div>
                                </div>

                                <div class="col-lg-2 mb-3">
                                    <label for="building_number" class="control-label parent-label">{{ __('realestate.build_number') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-building"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="building_number" name="building_number" value="{{ old('building_number', $tenant->building_number) }}">
                                    </div>
                                </div>

                                <div class="col-lg-2 mb-3">
                                    <label for="postcode" class="control-label parent-label">{{ __('realestate.postcode') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-mail-bulk"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="postcode" name="postcode" value="{{ old('postcode', $tenant->postcode) }}">
                                    </div>
                                </div>

                                <div class="col-lg-2 mb-3">
                                    <label for="id_number" class="control-label parent-label">رقم الهوية / الإقامة</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-id-card"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="id_number" name="id_number" value="{{ old('id_number', $tenant->id_number ?? '') }}">
                                    </div>
                                </div>

                                <div class="col-lg-2 mb-3">
                                    <label for="nationality" class="control-label parent-label">الجنسية</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-globe"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="nationality" name="nationality" value="{{ old('nationality', $tenant->nationality ?? '') }}">
                                    </div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label for="notes" class="control-label parent-label">{{ __('realestate.product_notes') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sticky-note"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="notes" name="notes" value="{{ old('notes', $tenant->notes) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- أزرار الحفظ والإلغاء --}}
                        <div class="d-flex justify-content-center mb-4 pt-2">
                            <button style="background-color: #419BB2; border-color: #419BB2; padding: 10px 30px; font-size: 16px;" type="submit" class="btn btn-primary shadow-sm ml-2">
                                <i class="fas fa-sync-alt ml-2"></i> {{ __('realestate.update') ?? 'تحديث البيانات' }}
                            </button>
                            <a href="{{ route('tenants.index') }}" class="btn btn-secondary px-4 py-2" style="font-size: 16px;">
                                <i class="fas fa-times ml-1"></i> {{ __('realestate.cancel') ?? 'إلغاء' }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection