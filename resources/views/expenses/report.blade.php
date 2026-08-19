@extends('layouts.master')

@section('css')
<style>
    .card-header-custom { background: #fff; border-bottom: 1px solid #eee; padding: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
    .btn-custom { border-radius: 8px; font-weight: 600; padding: 6px 15px; }
</style>
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('title') 
{{ __('realestate.expense_report') ?? 'تقرير مصروفات العقارات' }} 
@endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <h4 class="content-title mb-0">{{ __('realestate.reports') ?? 'التقارير' }} / {{ __('realestate.expense_report') ?? 'تقرير المصروفات' }}</h4>
</div>
@endsection

@section('content')
<div class="row">
    <!-- نموذج البحث والفلاتر -->
    <div class="col-md-12 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary"><i class="fas fa-filter mr-2"></i> {{ __('realestate.search_filters') ?? 'خيارات البحث والفلترة' }}</h5>
            </div>
            <div class="card-body">
                <!-- أضفنا id="searchForm" للفورم -->
                <form id="searchForm" action="{{ route('property_expenses.report') }}" method="GET" autocomplete="off">
                    <div class="row">
                        <!-- البحث بالعقار -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label font-weight-bold">{{ __('realestate.select_property') ?? 'العقار' }}</label>
                            <select name="property_id" class="form-control select2">
                                <option value="">{{ __('realestate.all_properties') ?? 'جميع العقارات' }}</option>
                                @foreach($properties as $property)
                                    <option value="{{ $property->id }}" {{ request('property_id') == $property->id ? 'selected' : '' }}>
                                        {{ $property->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- سبب/نوع الصرف -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label font-weight-bold">{{ __('realestate.expense_type') ?? 'نوع/سبب المصروف' }}</label>
                            <select name="expense_type" class="form-control select2">
                                <option value="">{{ __('realestate.all_types') ?? 'جميع الأنواع' }}</option>
                                <option value="water" {{ request('expense_type') == 'water' ? 'selected' : '' }}>{{ __('realestate.water') ?? 'ماء' }}</option>
                                <option value="electricity" {{ request('expense_type') == 'electricity' ? 'selected' : '' }}>{{ __('realestate.electricity') ?? 'كهرباء' }}</option>
                                <option value="maintenance" {{ request('expense_type') == 'maintenance' ? 'selected' : '' }}>{{ __('realestate.general_maintenance') ?? 'صيانة عامة' }}</option>
                                <option value="other" {{ request('expense_type') == 'other' ? 'selected' : '' }}>{{ __('realestate.other') ?? 'أخرى' }}</option>
                            </select>
                        </div>

                        <!-- التاريخ من -->
                        <div class="col-md-2 mb-3">
                            <label class="form-label font-weight-bold">{{ __('realestate.from_date') ?? 'من تاريخ' }}</label>
                            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                        </div>

                        <!-- التاريخ إلى -->
                        <div class="col-md-2 mb-3">
                            <label class="form-label font-weight-bold">{{ __('realestate.to_date') ?? 'إلى تاريخ' }}</label>
                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>

                        <!-- أزرار البحث -->
                        <div class="col-md-2 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-custom btn-block shadow-sm mr-1">
                                <i class="fas fa-search"></i> {{ __('realestate.search') ?? 'بحث' }}
                            </button>
                            <a href="{{ route('property_expenses.report') }}" class="btn btn-secondary btn-custom shadow-sm" title="إعادة ضبط">
                                <i class="fas fa-redo"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- جدول النتائج -->
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header-custom">
                <h5 class="mb-0 text-primary"><i class="fas fa-list mr-2"></i> {{ __('realestate.results') ?? 'نتائج التقرير' }}</h5>
                <div>
                    <!-- أضفنا id="totalAmountBadge" لتحديث المبلغ -->
                    <span id="totalAmountBadge" class="badge badge-primary p-2" style="font-size: 14px;">
                        {{ __('realestate.total_amount') ?? 'إجمالي المصروفات' }}: {{ number_format($totalAmount, 2) }} ريال
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('realestate.expense_date') ?? 'التاريخ' }}</th>
                                <th>{{ __('realestate.property') ?? 'العقار' }}</th>
                                <th>{{ __('realestate.unit') ?? 'الوحدة' }}</th>
                                <th>{{ __('realestate.expense_type') ?? 'نوع المصروف' }}</th>
                                <th>{{ __('realestate.amount') ?? 'المبلغ' }}</th>
                                <th>{{ __('realestate.payment_method') ?? 'طريقة الدفع' }}</th>
                                <th>{{ __('realestate.description') ?? 'البيان' }}</th>
                            </tr>
                        </thead>
                        <!-- أضفنا id="resultsTable" لتحديث الجدول -->
                        <tbody id="resultsTable">
                            @forelse($expenses as $index => $expense)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $expense->expense_date }}</td>
                                    <td>{{ optional($expense->property)->name }}</td>
                                    <td>{{ optional($expense->unit)->name ?? optional($expense->unit)->unit_number ?? 'عام' }}</td>
                                    <td>
                                        @if($expense->expense_type == 'water') ماء
                                        @elseif($expense->expense_type == 'electricity') كهرباء
                                        @elseif($expense->expense_type == 'maintenance') صيانة عامة
                                        @else أخرى @endif
                                    </td>
                                    <td class="font-weight-bold text-danger">{{ number_format($expense->amount, 2) }}</td>
                                    <td>{{ $expense->payment_method == 'cash' ? 'نقدي' : 'تحويل بنكي' }}</td>
                                    <td>{{ $expense->description ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-muted py-4">{{ __('realestate.no_data') ?? 'لا توجد بيانات مطابقة للبحث' }}</td>
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

@section('js')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            dir: "rtl",
            width: '100%'
        });

        // كود الـ AJAX للبحث بدون تحميل الصفحة
        $('#searchForm').on('submit', function(e) {
            e.preventDefault(); // منع الإرسال التقليدي

            let form = $(this);
            let url = form.attr('action');
            let btn = form.find('button[type="submit"]');
            let originalBtnText = btn.html();

            // إظهار علامة التحميل على الزر
            btn.html('<i class="fas fa-spinner fa-spin"></i> جاري البحث...').prop('disabled', true);

            $.ajax({
                url: url,
                type: "GET",
                data: form.serialize(), // أخذ بيانات الفورم
                success: function(response) {
                    // 1. تحديث الإجمالي
                    let totalText = "{{ __('realestate.total_amount') ?? 'إجمالي المصروفات' }}";
                    $('#totalAmountBadge').text(totalText + ': ' + response.totalAmount + ' ريال');

                    // 2. تحديث جدول البيانات
                    let tbody = $('#resultsTable');
                    tbody.empty(); // مسح البيانات القديمة

                    if (response.expenses.length === 0) {
                        let noDataText = "{{ __('realestate.no_data') ?? 'لا توجد بيانات مطابقة للبحث' }}";
                        tbody.append(`<tr><td colspan="8" class="text-muted py-4">${noDataText}</td></tr>`);
                    } else {
                        // طباعة الصفوف الجديدة
                        $.each(response.expenses, function(index, exp) {
                            tbody.append(`
                                <tr>
                                    <td>${exp.index}</td>
                                    <td>${exp.date}</td>
                                    <td>${exp.property_name}</td>
                                    <td>${exp.unit_name}</td>
                                    <td>${exp.type}</td>
                                    <td class="font-weight-bold text-danger">${exp.amount}</td>
                                    <td>${exp.payment_method}</td>
                                    <td>${exp.description}</td>
                                </tr>
                            `);
                        });
                    }

                    // إعادة الزر لشكله الطبيعي
                    btn.html(originalBtnText).prop('disabled', false);
                },
                error: function(xhr) {
                    alert('حدث خطأ أثناء البحث. يرجى المحاولة مرة أخرى.');
                    btn.html(originalBtnText).prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection