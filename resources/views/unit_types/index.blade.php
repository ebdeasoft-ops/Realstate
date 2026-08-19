@extends('layouts.master')

@section('title')
{{ __('unit_types.title') }}
@endsection

@section('content')
<div class="row">
    <!-- نموذج الإضافة -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">{{ __('unit_types.add_new') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('unit-types.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="font-weight-bold">{{ __('unit_types.name_ar') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name_ar" class="form-control" required placeholder="مثال: شقة عوائل">
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold">{{ __('unit_types.name_en') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name_en" class="form-control" required placeholder="مثال: Family Apartment">
                    </div>

                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fas fa-save"></i> {{ __('unit_types.save') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- جدول عرض الأنواع -->
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">{{ __('unit_types.list') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>{{ __('unit_types.index') }}</th>
                                <th>{{ __('unit_types.arabic_name') }}</th>
                                <th>{{ __('unit_types.english_name') }}</th>
                                <th>{{ __('unit_types.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($unitTypes as $index => $type)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $type->name_ar }}</td>
                                <td>{{ $type->name_en }}</td>
                                <td>
                                    <!-- زر الحذف -->
                                    <form action="{{ route('unit-types.destroy', $type->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('unit_types.confirm_delete') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> {{ __('unit_types.delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-muted py-3">{{ __('unit_types.no_data') }}</td>
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