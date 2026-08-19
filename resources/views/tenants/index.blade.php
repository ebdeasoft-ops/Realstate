@extends('layouts.master')

@section('title')
    {{ __('realestate.tenants') }}
@endsection

@section('css')
    <!-- تضمين مكتبة Select2 CSS للبحث داخل القائمة المنسدلة -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* تنسيق مظهر Select2 ليطابق تصميم Bootstrap */
        .select2-container .select2-selection--single {
            height: calc(1.5em + .75rem + 2px);
            padding: .375rem .75rem;
            border: 1px solid #ced4da;
            border-radius: .25rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
            padding-left: 0;
            color: #495057;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 34px;
        }
        /* مؤشر تحميل خفيف أثناء جلب البيانات */
        #tenants-container {
            position: relative;
        }
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
    </style>
@endsection

@section('content')
    <br>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 text-primary"><i class="fas fa-users mr-2"></i> {{ __('realestate.tenants') ?? 'إدارة المستأجرين' }}</h5>
                    <a href="{{ route('tenants.create') }}" class="btn btn-success btn-sm shadow-sm">
                        <i class="fas fa-plus ml-1"></i> {{ __('realestate.add_tenant') ?? 'إضافة مستأجر جديد' }}
                    </a>
                </div>
                <div class="card-body">
                    
                    {{-- نموذج البحث (قائمة Select للبحث بالاسم + خانة بحث رقم الهوية) --}}
                    <form id="search-form" action="{{ route('tenants.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            {{-- قائمة Select لاختيار اسم المستأجر مع تفعيل البحث (Select2) --}}
                            <div class="col-md-5 mb-2">
                                <select name="tenant_id" class="form-control select2">
                                    <option value=""></option>
                                    @foreach($allTenants as $t)
                                        <option value="{{ $t->id }}" {{ request('tenant_id') == $t->id ? 'selected' : '' }}>
                                            {{ $t->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- بحث برقم الهوية / الإقامة --}}
                            <div class="col-md-5 mb-2">
                                <input type="text" name="search_id" class="form-control" placeholder="{{ __('realestate.id_number') ?? 'البحث برقم الهوية / الإقامة' }}" value="{{ request('search_id') }}">
                            </div>

                            {{-- أزرار البحث وإعادة التعيين --}}
                            <div class="col-md-2 mb-2 d-flex">
                                <button type="submit" class="btn btn-primary btn-block mr-1">
                                    <i class="fas fa-search ml-1"></i> {{ __('realestate.search') ?? 'بحث' }}
                                </button>
                                <a href="{{ route('tenants.index') }}" class="btn btn-secondary" title="إعادة تعيين" id="reset-btn">
                                    <i class="fas fa-redo"></i>
                                </a>
                            </div>
                        </div>
                    </form>

                    {{-- حاوية الجدول والبيانات لتحديثها بـ AJAX --}}
                    <div id="tenants-container">
                        <div class="loading-overlay">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">جاري التحميل...</span>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-bordered text-center align-middle">
                                <thead class="thead-light bg-light">
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('realestate.tenant_name') ?? 'اسم المستأجر' }}</th>
                                        <th>{{ __('realestate.phone') ?? 'رقم الجوال' }}</th>
                                        <th>{{ __('realestate.id_number') ?? 'رقم الهوية' }}</th>
                                        <th>{{ __('realestate.nationality') ?? 'الجنسية' }}</th>
                                        <th>{{ __('realestate.address') ?? 'العنوان' }}</th>
                                        <th>{{ __('realestate.tax_number') ?? 'الرقم الضريبي' }}</th>
                                        <th>{{ __('realestate.balance') ?? 'الرصيد' }}</th>
                                        <th>{{ __('realestate.actions') ?? 'العمليات' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tenants as $tenant)
                                        <tr>
                                            <td>{{ $tenants->firstItem() + $loop->index }}</td>
                                            <td class="font-weight-bold text-dark">{{ $tenant->name }}</td>
                                            <td>{{ $tenant->phone ?? '-' }}</td>
                                            <td>{{ $tenant->id_number ?? '-' }}</td>
                                            <td>{{ $tenant->nationality ?? '-' }}</td>
                                            <td>{{ $tenant->address ?? '-' }}</td>
                                            <td>
                                                <span class="badge badge-info">{{ $tenant->tax_no ?? '-' }}</span>
                                            </td>
                                            <td class="text-success font-weight-bold">
                                                {{ number_format($tenant->Balance ?? 0, 2) }}
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('tenants.show', $tenant->id) }}" class="btn btn-sm btn-info text-white" title="عرض">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('tenants.edit', $tenant->id) }}" class="btn btn-sm btn-primary" title="تعديل">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('tenants.destroy', $tenant->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المستأجر؟');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-muted py-4">
                                                <i class="fas fa-info-circle mr-1"></i> {{ __('realestate.no_tenants') ?? 'لا توجد بيانات مستأجرين حالياً' }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- روابط التقسيم (Pagination Links) --}}
                        <div class="d-flex justify-content-center mt-4 pagination-container">
                            {{ $tenants->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- تضمين مكتبة Select2 JS وتشغيلها -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // تفعيل Select2
            $('.select2').select2({
                placeholder: "{{ __('realestate.select_tenant') ?? 'اختر المستأجر (ابحث بالاسم)...' }}",
                allowClear: true,
                width: '100%'
            });

            // دالة لجلب البيانات عبر AJAX
            function fetchTenants(url) {
                $('.loading-overlay').show();
                
                // جمع بيانات نموذج البحث مع الرابط
                var formData = $('#search-form').serialize();
                var separator = url.includes('?') ? '&' : '?';
                var fullUrl = url + separator + formData;

                $.ajax({
                    url: fullUrl,
                    type: 'GET',
                    success: function(response) {
                        // استخلاص محتوى جدول المستأجرين والـ pagination من الـ HTML القادم
                        var newContent = $(response).find('#tenants-container').html();
                        $('#tenants-container').html(newContent);
                        
                        // إعادة تفعيل Select2 بعد تحديث الـ DOM إن احتجت
                        $('.select2').select2({
                            placeholder: "{{ __('realestate.select_tenant') ?? 'اختر المستأجر (ابحث بالاسم)...' }}",
                            allowClear: true,
                            width: '100%'
                        });
                        
                        // تحديث عنوان الـ URL في المتصفح دون إعادة تحميل
                        window.history.pushState({path: fullUrl}, '', fullUrl);
                        $('.loading-overlay').hide();
                    },
                    error: function() {
                        alert('حدث خطأ أثناء تحميل البيانات.');
                        $('.loading-overlay').hide();
                    }
                });
            }

            // عند الضغط على روابط الصفحات (Pagination) أو روابط التصفح داخل الحاوية
            $(document).on('click', '.pagination-container a, .pagination a', function(e) {
                e.preventDefault();
                var pageUrl = $(this).attr('href');
                if(pageUrl) {
                    fetchTenants(pageUrl);
                }
            });

            // (اختياري) جعل البحث أيضاً يعمل بـ AJAX عند الضغط على بحث
            $('#search-form').on('submit', function(e) {
                e.preventDefault();
                var url = $(this).attr('action');
                fetchTenants(url);
            });
        });
    </script>
@endsection