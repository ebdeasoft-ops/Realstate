@extends('layouts.master')

@section('css')
    <!-- مكتبة Select2 للبحث في القوائم -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body { background: #e9e5da; font-family: 'Tajawal', Arial, sans-serif; }
        .table-wrap { color: #1f2a24; position: relative; }
        
        /* مؤشر تحميل خفيف أثناء جلب البيانات عبر الـ AJAX */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 999;
            display: none;
        }

        /* تنسيقات ألوان الصفوف بناءً على حالة القسط */
        .tr-overdue { background-color: #f8d7da !important; } /* أحمر فاتح للأقساط المتأخرة */
        .tr-warning { background-color: #fff3cd !important; } /* أصفر/برتقالي فاتح للأقساط القريبة */
        .tr-paid { background-color: #d4edda !important; }    /* أخضر فاتح للأقساط المدفوعة */

        /* تنسيق مربعات الإحصائيات العلوية */
        .stat-card {
            border-radius: 8px;
            color: #fff;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* إصلاح ظهور حقل البحث الخاص بـ Select2 باللغة العربية */
        .select2-container { width: 100% !important; }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #aaa;
            padding: 4px;
            direction: rtl;
        }
    </style>
@endsection

@section('title')
    {{ __('realestate.rent_installments') ?? 'إدارة أقساط الإيجار' }}
@stop

@section('page-header')
    <div class="main-parent no-print">
        <div class="breadcrumb-header justify-content-between parent-heading">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">
                        <i class="fas fa-file-invoice-dollar text-primary ml-2"></i> 
                        {{ __('realestate.installments_schedule') ?? 'جدول أقساط الإيجار المرتبطة بالعقود' }}
                    </h4>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
<br>
    <div class="table-wrap">
        <!-- طبقة التحميل الخاصة بالـ AJAX -->
        <div class="loading-overlay">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">جاري التحميل...</span>
            </div>
        </div>

        <!-- مربعات الإحصائيات (Cards) العلوية -->
        <div class="row text-center">
            <div class="col-md-3">
                <div class="stat-card bg-danger">
                    <h6 class="font-weight-bold">المتأخرة (فائتة)</h6>
                    <h3 class="mb-0">{{ number_format($totalOverdue ?? 0, 2) }}</h3>
                    <small>ر.س</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-warning text-dark">
                    <h6 class="font-weight-bold">قريبة الاستحقاق</h6>
                    <h3 class="mb-0">{{ number_format($totalWarning ?? 0, 2) }}</h3>
                    <small>ر.س</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-success">
                    <h6 class="font-weight-bold">المحصلة (المدفوعة)</h6>
                    <h3 class="mb-0">{{ number_format($totalPaid ?? 0, 2) }}</h3>
                    <small>ر.س</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-info">
                    <h6 class="font-weight-bold">إجمالي المبالغ</h6>
                    <h3 class="mb-0">{{ number_format($totalAmount ?? 0, 2) }}</h3>
                    <small>ر.س</small>
                </div>
            </div>
        </div>

        <!-- قسم البحث والتصفية بالقوائم المنسدلة -->
        <div class="row justify-content-center mb-3">
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form id="search-form" action="{{ route('installments.index') }}" method="GET">
                            <div class="row align-items-end">
                                <!-- قائمة المستأجرين مع خاصية البحث -->
                                <div class="col-md-3 form-group mb-2">
                                    <label class="small font-weight-bold">{{ __('realestate.tenant') ?? 'المستأجر' }}:</label>
                                    <select name="tenant_id" class="form-control form-control-sm select2-search">
                                        <option value="">-- {{ __('realestate.all_tenants') ?? 'كل المستأجرين' }} --</option>
                                        @isset($tenants)
                                            @foreach($tenants as $tenant)
                                                <option value="{{ $tenant->id }}" {{ request('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                                    {{ $tenant->name ?? 'مستأجر #' . $tenant->id }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>

                                <!-- قائمة الوحدات مع خاصية البحث -->
                                <div class="col-md-2 form-group mb-2">
                                    <label class="small font-weight-bold">{{ __('realestate.unit') ?? 'الوحدة' }}:</label>
                                    <select name="unit_id" class="form-control form-control-sm select2-search">
                                        <option value="">-- {{ __('realestate.all_units') ?? 'كل الوحدات' }} --</option>
                                        @isset($units)
                                            @foreach($units as $unit)
                                                <option value="{{ $unit->id }}" {{ request('unit_id') == $unit->id ? 'selected' : '' }}>
                                                    {{ $unit->name ?? 'وحدة #' . $unit->id }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>

                                <div class="col-md-2 form-group mb-2">
                                    <label class="small font-weight-bold">{{ __('realestate.from_due_date') ?? 'من تاريخ استحقاق' }}:</label>
                                    <input type="date" name="from_date" class="form-control form-control-sm" value="{{ request('from_date') }}">
                                </div>
                                <div class="col-md-2 form-group mb-2">
                                    <label class="small font-weight-bold">{{ __('realestate.to_due_date') ?? 'إلى تاريخ استحقاق' }}:</label>
                                    <input type="date" name="to_date" class="form-control form-control-sm" value="{{ request('to_date') }}">
                                </div>
                                <div class="col-md-3 form-group mb-2 d-flex">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block ml-1"><i class="fa-solid fa-search ml-1"></i> {{ __('realestate.search') ?? 'بحث' }}</button>
                                    <a href="{{ route('installments.index') }}" class="btn btn-secondary btn-sm" title="{{ __('realestate.reset') ?? 'إعادة ضبط' }}" id="reset-btn"><i class="fa-solid fa-rotate-right"></i></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- جدول النتائج والـ Pagination محاطين بـ Container لتحديثهما بـ AJAX -->
        <div id="installments-container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle text-right">
                                    <thead class="table-light">
                                        <tr>
                                            <th>{{ __('realestate.installment_number') ?? '# القسط' }}</th>
                                            <th>{{ __('realestate.contract_id') ?? 'رقم العقد' }}</th>
                                            <th>{{ __('realestate.unit') ?? 'رقم الوحدة' }}</th>
                                            <th>{{ __('realestate.tenant') ?? 'المستأجر' }}</th>
                                            <th>{{ __('realestate.total_amount') ?? 'إجمالي القسط' }}</th>
                                            <th>{{ __('realestate.paid_amount') ?? 'المدفوع' }}</th>
                                            <th>{{ __('realestate.remaining_amount') ?? 'المتبقي' }}</th>
                                            <th>{{ __('realestate.due_date') ?? 'تاريخ الاستحقاق' }}</th>
                                            <th>{{ __('realestate.status') ?? 'الحالة' }}</th>
                                            <th>{{ __('realestate.actions') ?? 'الإجراءات' }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @isset($installments)
                                            @forelse($installments as $installment)
                                                @php
                                                    $remaining = $installment->amount - $installment->paid_amount;
                                                    
                                                    // حساب التلوين الشرطي للصفوف
                                                    $dueDate = \Carbon\Carbon::parse($installment->due_date);
                                                    $today = \Carbon\Carbon::now();
                                                    $rowClass = '';

                                                    if ($installment->status == 'paid') {
                                                        $rowClass = 'tr-paid'; // أخضر
                                                    } elseif ($dueDate->isPast()) {
                                                        $rowClass = 'tr-overdue'; // أحمر (فائت موعده)
                                                    } elseif ($dueDate->diffInDays($today) <= 5 && !$dueDate->isPast()) {
                                                        $rowClass = 'tr-warning'; // برتقالي (قريب الاستحقاق خلال 5 أيام)
                                                    }
                                                @endphp
                                                <tr class="{{ $rowClass }}">
                                                    <td><span class="badge badge-secondary">{{ $installment->installment_number }}</span></td>
                                                    <td><span class="badge badge-info">{{ $installment->contract_id }}</span></td>
                                                    <td>{{ $installment->unit_id }}</td>
                                                    <td>{{ $installment->tenant_name ?? 'غير محدد' }}</td>
                                                    <td class="font-weight-bold">{{ number_format($installment->amount, 2) }} ر.س</td>
                                                    <td class="text-success">{{ number_format($installment->paid_amount, 2) }} ر.س</td>
                                                    <td class="text-danger font-weight-bold">{{ number_format($remaining, 2) }} ر.س</td>
                                                    <td>{{ $installment->due_date ?? '-' }}</td>
                                                    <td>
                                                        @if($installment->status == 'paid')
                                                            <span class="badge badge-success">{{ __('realestate.fully_paid') ?? 'مدفوع بالكامل' }}</span>
                                                        @elseif($installment->paid_amount > 0)
                                                            <span class="badge badge-info">{{ __('realestate.partially_paid') ?? 'مسدد جزئياً' }}</span>
                                                        @elseif($dueDate->isPast())
                                                            <span class="badge badge-danger">متأخر</span>
                                                        @else
                                                            <span class="badge badge-warning">{{ __('realestate.unpaid') ?? 'غير مدفوع' }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($remaining > 0)
                                                            <a href="{{ route('installments.pay', $installment->id) }}" class="btn btn-sm btn-outline-success mb-1" title="{{ __('realestate.pay') ?? 'تسديد' }}">
                                                                <i class="fa-solid fa-money-bill-wave"></i> {{ __('realestate.pay') ?? 'تسديد' }}
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="10" class="text-center py-4 text-muted">{{ __('realestate.no_results') ?? 'لا توجد نتائج مطابقة للبحث' }}</td>
                                                </tr>
                                            @endforelse
                                        @endisset
                                    </tbody>
                                </table>
                            </div>

                            <!-- روابط الـ Pagination -->
                            <div class="d-flex justify-content-center mt-4 pagination-container">
                                @isset($installments)
                                    {{ $installments->links() }}
                                @endisset
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- مكتبة Select2 للـ JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // تفعيل ميزة البحث في القوائم المنسدلة
            function initSelect2() {
                $('.select2-search').select2({
                    placeholder: "-- اختر --",
                    allowClear: true,
                    width: '100%'
                });
            }

            initSelect2();

            // دالة جلب البيانات عبر AJAX
            function fetchInstallments(url) {
                $('.loading-overlay').show();
                
                var formData = $('#search-form').serialize();
                var separator = url.includes('?') ? '&' : '?';
                var fullUrl = url + separator + formData;

                $.ajax({
                    url: fullUrl,
                    type: 'GET',
                    success: function(response) {
                        var newContent = $(response).find('#installments-container').html();
                        $('#installments-container').html(newContent);
                        
                        window.history.pushState({path: fullUrl}, '', fullUrl);
                        $('.loading-overlay').hide();
                        initSelect2(); // إعادة تفعيل Select2 بعد التحديث إن أمكن
                    },
                    error: function() {
                        alert('حدث خطأ أثناء تحميل البيانات.');
                        $('.loading-overlay').hide();
                    }
                });
            }

            // عند الضغط على روابط الـ Pagination
            $(document).on('click', '#installments-container .pagination a', function(e) {
                e.preventDefault();
                var pageUrl = $(this).attr('href');
                if(pageUrl) {
                    fetchInstallments(pageUrl);
                }
            });

            // جعل نموذج البحث يعمل بـ AJAX أيضاً
            $('#search-form').on('submit', function(e) {
                e.preventDefault();
                var url = $(this).attr('action');
                fetchInstallments(url);
            });
        });
    </script>
@endsection