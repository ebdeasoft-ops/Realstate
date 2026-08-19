@extends('layouts.master')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css">
<style>
    .table thead th { background-color: #f8f9fe; border-bottom: 2px solid #e1e5ef; color: #444; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .table tbody tr:hover { background-color: #f1f4f9; transition: 0.3s; }
    .btn-custom { border-radius: 8px; font-weight: 600; padding: 6px 15px; }
    .card-header-custom { background: #fff; border-bottom: 1px solid #eee; padding: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }

    #owners-container { position: relative; }
    .loading-overlay {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(255, 255, 255, 0.7); display: none;
        justify-content: center; align-items: center; z-index: 999;
    }

    /* ------ إصلاح مشكلة خلفية قائمة Select2 الشفافة ------ */
    .select2-container {
        z-index: 1051; /* أعلى من أي عنصر تاني في الكارت */
    }
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
    .select2-results__options {
        background-color: #fff !important;
    }
    .select2-results__option {
        background-color: #fff !important;
        color: #333 !important;
    }
    .select2-results__option--highlighted[aria-selected] {
        background-color: #0d6efd !important;
        color: #fff !important;
    }
    .select2-search--dropdown {
        background-color: #fff !important;
    }
    .select2-search--dropdown .select2-search__field {
        border: 1px solid #ced4da !important;
    }
</style>
@endsection

@section('title') {{ __('realestate.owners') }} @endsection

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <h4 class="content-title mb-0">{{ __('realestate.owners') }}</h4>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header-custom">
                <h5 class="mb-0 text-primary"><i class="fas fa-users mr-2"></i> {{ __('realestate.owners') }}</h5>
                <a href="{{ route('owners.create') }}" class="btn btn-primary btn-custom shadow-sm">
                    <i class="fas fa-plus"></i> {{ __('realestate.add_owner') }}
                </a>
            </div>

            <!-- تم نقل الـ id هنا لكي يشمل نموذج البحث والجدول معاً -->
            <div class="card-body" id="owners-container">
                <div class="loading-overlay">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>

                <!-- نموذج البحث -->
                <div class="row mb-3">
                    <div class="col-md-10">
                        <form id="search-form" action="{{ route('owners.index') }}" method="GET" class="form-inline">
                            <div class="row w-100">
                                <div class="col-md-4">
                                    <select name="name" id="name-select" class="form-control select2 w-100">
                                        <option value="">-- اختر الاسم --</option>
                                        @foreach($allNames as $name)
                                            <option value="{{ $name }}" {{ request('name') == $name ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="national_id" class="form-control w-100"
                                           placeholder="بحث برقم الهوية..." value="{{ request('national_id') }}">
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> بحث</button>
                                    <a href="{{ route('owners.index') }}" class="btn btn-secondary"><i class="fas fa-undo"></i></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover text-center" id="ownersTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('realestate.name') }}</th>
                                <th>{{ __('realestate.phone') }}</th>
                                <th>{{ __('realestate.national_id') }}</th>
                                <th>{{ __('realestate.bank_account') }}</th>
                                <th>{{ __('realestate.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($owners as $index => $owner)
                            <tr>
                                <td>{{ $owners->firstItem() + $index }}</td>
                                <td>{{ $owner->name }}</td>
                                <td>{{ $owner->phone ?? '-' }}</td>
                                <td>{{ $owner->national_id ?? '-' }}</td>
                                <td>{{ $owner->bank_account_number ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('owners.show', $owner->id) }}" class="btn btn-sm btn-info btn-custom">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-muted py-4">لا توجد نتائج مطابقة</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $owners->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
<script>
    // دالة لتفعيل Select2 (بتتأكد إنها تدمر أي instance قديمة الأول عشان منعملش تهيئة مزدوجة)
    function initSelect2() {
        $('.select2').each(function () {
            if ($(this).data('select2')) {
                $(this).select2('destroy');
            }
        });
        $('.select2').select2({
            placeholder: "اختر الاسم...",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#owners-container')
        });
    }

    $(document).ready(function() {
        initSelect2();
    });

    function fetchOwners(url) {
        $('.loading-overlay').show();
        var formData = $('#search-form').serialize();

        $.ajax({
            url: url,
            type: 'GET',
            data: formData,
            success: function(response) {
                var newContent = $(response).find('#owners-container').html();
                $('#owners-container').html(newContent);

                // إعادة تفعيل Select2 بعد تحديث الـ DOM
                initSelect2();

                window.history.pushState({path: url}, '', url);
                $('.loading-overlay').hide();
            },
            error: function() {
                alert('حدث خطأ أثناء تحميل البيانات.');
                $('.loading-overlay').hide();
            }
        });
    }

    // البحث التلقائي عند اختيار الاسم من Select2
    $(document).on('change', '#name-select', function() {
        fetchOwners("{{ route('owners.index') }}");
    });

    // عند إرسال نموذج البحث (زر بحث)
    $(document).on('submit', '#search-form', function(e) {
        e.preventDefault();
        fetchOwners($(this).attr('action'));
    });

    // عند الانتقال بين صفحات الـ Pagination
    $(document).on('click', '#owners-container .pagination a', function(e) {
        e.preventDefault();
        fetchOwners($(this).attr('href'));
    });
</script>
@endsection