@extends('layouts.master')

@section('css')
<style>
    .report-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .report-title { border-bottom: 2px solid #007bff; padding-bottom: 12px; margin-bottom: 20px; }
    .row-item { display: flex; justify-content: space-between; padding: 14px 0; border-bottom: 1px dashed #eee; font-size: 16px; }
    .value-num { color: #007bff; font-weight: bold; }
    #loading { display: none; text-align: center; padding: 20px; font-size: 1.2rem; }
    .no-print { margin-bottom: 20px; }
</style>
<style>
    .report-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
    .report-title { border-bottom: 2px solid #007bff; padding-bottom: 12px; margin-bottom: 20px; }
    #loading { display: none; text-align: center; padding: 20px; font-size: 1.2rem; }
    
    @media print {
        /* إخفاء القوائم الجانبية، الهيدر، الشعار، ونموذج البحث تماماً عند الطباعة */
        main, header, nav, aside, .sidebar, .breadcrumb-header, .no-print, #reportForm, .card:first-child {
            display: none !important;
        }
        
        /* ضبط حاوية التقرير لتمتد بعرض الصفحة وبدون ظلال أو حدود */
        #reportContainer, .report-card {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            box-shadow: none !important;
        }

        body {
            background-color: #fff !important;
        }
        
        /* الحفاظ على ألوان الجداول والخلفيات واضحة عند الطباعة */
        .card, .p-3, .bg-light, .bg-success {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('title')
{{ __('realestate.net_revenue') }}
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <h4 class="content-title mb-0">{{ __('realestate.net_revenue') }}</h4>
</div>
@endsection

@section('content')
<div class="row">
    <!-- نموذج البحث -->
    <div class="col-md-12 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form id="reportForm" autocomplete="off">
                    @csrf
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label class="font-weight-bold">{{ __('realestate.property') }}</label>
                            <select name="property_id" class="form-control select2" required>
                                <option value="">---</option>
                                @foreach($properties as $property)
                                    <option value="{{ $property->id }}">{{ $property->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="font-weight-bold">{{ __('realestate.from_date') }}</label>
                            <input type="date" name="from_date" class="form-control" value="{{ date('Y-01-01') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="font-weight-bold">{{ __('realestate.to_date') }}</label>
                            <input type="date" name="to_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-block" id="searchBtn">
                                {{ __('realestate.search_btn') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- مؤشر التحميل -->
    <div class="col-md-12">
        <div id="loading">
            <i class="fas fa-spinner fa-spin"></i> {{ __('realestate.loading') }}
        </div>
        <!-- حاوية النتائج -->
        <div id="reportContainer"></div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // تهيئة Select2
        $('.select2').select2({ dir: "{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}", width: '100%' });

        // معالجة البحث عبر AJAX
        $('#reportForm').on('submit', function(e) {
            e.preventDefault();
            
            $('#loading').show();
            $('#reportContainer').empty();
            
            $.ajax({
                url: "{{ route('reports.net_revenue') }}",
                type: "GET",
                data: $(this).serialize(),
                success: function(response) {
                    $('#loading').hide();
                    $('#reportContainer').html(response.html);
                },
                error: function(xhr) {
                    $('#loading').hide();
                    alert('Error: ' + xhr.statusText);
                }
            });
        });
    });
</script>
@endsection