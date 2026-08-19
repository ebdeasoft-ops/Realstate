@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css">
<style>
    .table thead th { background-color: #f8f9fe; border-bottom: 2px solid #e1e5ef; color: #444; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .table tbody tr:hover { background-color: #f1f4f9; transition: 0.3s; }
    .badge { padding: 8px 12px; border-radius: 50px; font-size: 12px; }
    .btn-custom { border-radius: 8px; font-weight: 600; padding: 6px 15px; }
    .card-header-custom { background: #fff; border-bottom: 1px solid #eee; padding: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }

    /* ------ إصلاح مشكلة خانة البحث وقائمة Select2 الشفافة ------ */
    .select2-container { z-index: 1051; width: 100% !important; }
    .select2-container .select2-selection--single {
        height: calc(2.25rem + 2px) !important;
        display: flex;
        align-items: center;
        border: 1px solid #ced4da !important;
        border-radius: 6px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: normal !important;
        padding-right: 8px;
    }
    .select2-dropdown {
        background-color: #fff !important;
        border: 1px solid #ced4da !important;
        box-shadow: 0 6px 18px rgba(0,0,0,0.12);
        z-index: 1052;
    }
    .select2-results__options { background-color: #fff !important; }
    .select2-results__option { background-color: #fff !important; color: #333 !important; }
    .select2-results__option--highlighted[aria-selected] {
        background-color: #0d6efd !important;
        color: #fff !important;
    }
    /* خانة البحث نفسها فوق القايمة */
    .select2-search--dropdown {
        background-color: #fff !important;
        padding: 6px !important;
    }
    .select2-search--dropdown .select2-search__field {
        border: 1px solid #ced4da !important;
        border-radius: 4px !important;
        background-color: #fff !important;
        color: #333 !important;
        padding: 6px 8px !important;
    }
    .select2-search--dropdown .select2-search__field::placeholder {
        color: #888 !important;
        opacity: 1 !important;
    }
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
                <!-- نموذج البحث والتصنيف -->
                <form method="GET" action="{{ route('properties.index') }}" class="row mb-4" id="properties-filter-form">
                    <div class="col-md-4 mb-2">
                        <select name="property_name" id="property-name-select" class="form-control select2">
                            <option value="">{{ __('realestate.select_property_name') }}</option>
                            @foreach($allProperties as $prop)
                                <option value="{{ $prop->name }}" {{ request('property_name') == $prop->name ? 'selected' : '' }}>
                                    {{ $prop->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="type" id="property-type-select" class="form-control select2">
                            <option value="">{{ __('realestate.all_types') }}</option>
                            <option value="sale" {{ request('type') == 'sale' ? 'selected' : '' }}>{{ __('realestate.sale') }}</option>
                            <option value="rent" {{ request('type') == 'rent' ? 'selected' : '' }}>{{ __('realestate.rent') }}</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-custom flex-grow-1">{{ __('realestate.search') }}</button>
                        <a href="{{ route('properties.index') }}" class="btn btn-secondary btn-custom flex-grow-1" id="reset-filter-btn">{{ __('realestate.reset_filter') }}</a>
                    </div>
                </form>

                <!-- الحاوية التي سيتم تحديث محتواها تلقائياً عبر الـ AJAX -->
                <div id="properties-table-container">
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
                                    <td>{{ $properties->firstItem() + $index }}</td>
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

                    <!-- أزرار الترقيم (Pagination Links) -->
                    <div class="d-flex justify-content-center mt-4">
                        {!! $properties->appends(request()->query())->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- تضمين ملف JavaScript الخاص بـ Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // تفعيل مكتبة Select2 على القوائم المنسدلة
        $('.select2').select2({
            width: '100%'
        });

        var form = $('#properties-filter-form');

        // دالة لإرسال طلب الـ AJAX وتحديث الجدول والـ Pagination بسلاسة
        function fetchProperties(url, data) {
            $.ajax({
                url: url,
                type: 'GET',
                data: data,
                beforeSend: function() {
                    $('#properties-table-container').css('opacity', '0.5');
                },
                success: function(response) {
                    var newContent = $(response).find('#properties-table-container').html();
                    $('#properties-table-container').html(newContent);
                    $('#properties-table-container').css('opacity', '1');
                    
                    // تحديث رابط المتصفح بناءً على الفلترة والصفحة الحالية دون إعادة تحميل
                    window.history.pushState({}, '', url + (data ? (url.includes('?') ? '&' : '?') + $.param(data) : ''));
                },
                error: function() {
                    $('#properties-table-container').css('opacity', '1');
                    alert('حدث خطأ أثناء تحميل البيانات.');
                }
            });
        }

        // البحث التلقائي عند اختيار عنصر من قائمة Select2
        $('#property-name-select, #property-type-select').on('change', function () {
            var formData = form.serialize();
            fetchProperties(form.attr('action'), formData);
        });

        // عند الضغط على زر البحث اليدوي
        form.on('submit', function (e) {
            e.preventDefault();
            var formData = form.serialize();
            fetchProperties(form.attr('action'), formData);
        });

        // عند الضغط على زر إعادة التعيين (Reset)
        $('#reset-filter-btn').on('click', function (e) {
            e.preventDefault();
            $('#property-name-select').val('').trigger('change.select2');
            $('#property-type-select').val('').trigger('change.select2');
            fetchProperties($(this).attr('href'), {});
        });

        // التعامل مع أزرار التنقل بين الصفحات (Pagination) عبر AJAX حتى لا تحدث إعادة تحميل للصفحة
        $(document).on('click', '#properties-table-container .pagination a', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var formData = form.serialize();
            fetchProperties(url, formData);
        });
    });
</script>
@endsection