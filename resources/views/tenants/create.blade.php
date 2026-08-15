@extends('layouts.master')

@section('css')
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
    <!-- تأكد من وجود مكتبة FontAwesome للأيقونات -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('title')
    {{ __('realestate.add_tenant') }}
@stop

@section('page-header')
    <div class="main-parent">
        <div class="breadcrumb-header justify-content-between parent-heading">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto"><i class="fas fa-user-plus text-primary ml-2"></i> {{ __('realestate.add_tenant') }}</h4>
                </div>
            </div>
        </div>
    </div> 
@endsection

@section('content')

    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle ml-2"></i> <strong>{{ session()->get('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

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
                    <form action="{{ route('tenants.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        
                        {{-- القسم الأول: البيانات الأساسية للمستأجر --}}
                        <div class="card bg-light border-0 mb-4 p-3" style="border-radius: 8px;">
                            <h5 class="text-primary mb-3 font-weight-bold" style="font-size: 15px;">
                                <i class="fas fa-id-card ml-1"></i> البيانات الأساسية
                            </h5>
                            <div class="row">
                                <div class="col-lg-3 mb-3">
                                    <label for="name" class="control-label parent-label">{{ __('realestate.tenant_name') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="name" name="name" required placeholder="أدخل اسم المستأجر">
                                    </div>
                                </div>

                                <div class="col-lg-3 mb-3">
                                    <label for="phone" class="control-label parent-label">{{ __('realestate.phone') }} <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-phone-alt"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="phone" name="phone" required placeholder="05xxxxxxxx">
                                    </div>
                                </div>

                                {{-- حقل رقم الهوية الجديد --}}
                                <div class="col-lg-3 mb-3">
                                    <label for="id_number" class="control-label parent-label">رقم الهوية</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-id-card"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="id_number" name="id_number" placeholder="أدخل رقم الهوية">
                                    </div>
                                </div>

                                {{-- حقل الجنسية الجديد --}}
                                <div class="col-lg-3 mb-3">
                                    <label for="nationality" class="control-label parent-label">الجنسية</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-globe"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="nationality" name="nationality" placeholder="أدخل الجنسية">
                                    </div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label for="email" class="control-label parent-label">{{ __('realestate.email') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                                        <input type="email" class="form-control parent-input" id="email" name="email" placeholder="Example@gmail.com">
                                    </div>
                                </div>

                                <div class="col-lg-2 mb-3">
                                    <label for="balance" class="control-label parent-label">{{ __('realestate.current_balance') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-wallet"></i></span></div>
                                        <input type="number" step="0.01" class="parent-input form-control" id="balance" name="balance" value="0">
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
                                    <label for="timeout_period_in_days" class="control-label parent-label">{{ __('realestate.timeout_period') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-calendar-alt"></i></span></div>
                                        <input type="number" class="form-control parent-input" id="timeout_period_in_days" name="timeout_period_in_days" value="30">
                                    </div>
                                </div>

                                <div class="col-lg-3 mb-3">
                                    <label for="Tax_Number" class="control-label parent-label">{{ __('realestate.tax_number') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-receipt"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="Tax_Number" name="Tax_Number" maxlength="15" minlength="15" placeholder="15 رقم">
                                    </div>
                                </div>

                                <div class="col-lg-2 mb-3">
                                    <label for="CRN" class="control-label parent-label">{{ __('realestate.crn') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-certificate"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="CRN" name="CRN" value="0">
                                    </div>
                                </div>

                                <div class="col-lg-2 mb-3">
                                    <label for="credit_limit" class="control-label parent-label">{{ __('realestate.credit_limit') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span></div>
                                        <input type="number" class="form-control parent-input" id="credit_limit" name="credit_limit" value="10000">
                                    </div>
                                </div>

                                <div class="col-lg-2 mb-3">
                                    <label for="city" class="control-label parent-label">{{ __('realestate.city') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-city"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="city" name="city" placeholder="المدينة">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- القسم الثالث: تفاصيل العنوان الوطني والملاحظات --}}
                        <div class="card bg-light border-0 mb-4 p-3" style="border-radius: 8px;">
                            <h5 class="text-primary mb-3 font-weight-bold" style="font-size: 15px;">
                                <i class="fas fa-map-marked-alt ml-1"></i> العنوان الوطني والملاحظات
                            </h5>
                            <div class="row">
                                <div class="col-lg-2 mb-3">
                                    <label for="sub_city" class="control-label parent-label">{{ __('realestate.region') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-map"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="sub_city" name="sub_city" placeholder="الحي / المنطقة">
                                    </div>
                                </div>
                                
                                <div class="col-lg-2 mb-3">
                                    <label for="StreetName" class="control-label parent-label">{{ __('realestate.street_name') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-road"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="StreetName" name="StreetName" placeholder="اسم الشارع">
                                    </div>
                                </div>

                                <div class="col-lg-2 mb-3">
                                    <label for="plot_identification" class="control-label parent-label">{{ __('realestate.plot_identification') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-vector-square"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="plot_identification" name="plot_identification" placeholder="رقم القطعة">
                                    </div>
                                </div>

                                <div class="col-lg-2 mb-3">
                                    <label for="buildnumber" class="control-label parent-label">{{ __('realestate.build_number') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-building"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="buildnumber" name="buildnumber" placeholder="رقم المبنى">
                                    </div>
                                </div>

                                <div class="col-lg-2 mb-3">
                                    <label for="postcode" class="control-label parent-label">{{ __('realestate.postcode') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-mail-bulk"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="postcode" name="postcode" value="11461">
                                    </div>
                                </div>

                                <div class="col-lg-2 mb-3">
                                    <label for="product_notes" class="control-label parent-label">{{ __('realestate.product_notes') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-sticky-note"></i></span></div>
                                        <input type="text" class="form-control parent-input" id="product_notes" name="product_notes" placeholder="ملاحظات أخرى">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- زر الحفظ --}}
                        <div class="d-flex justify-content-center mb-4 pt-2">
                            <button style="background-color: #419BB2; border-color: #419BB2; padding: 10px 30px; font-size: 16px;" type="submit" class="btn btn-primary shadow-sm">
                                <i class="fas fa-save ml-2"></i> {{ __('realestate.save_data') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection