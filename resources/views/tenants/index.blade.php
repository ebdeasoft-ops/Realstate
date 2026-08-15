@extends('layouts.master')

@section('title')
    {{ __('realestate.tenants') }}
@endsection

@section('content')
    <br>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 text-primary"><i class="fas fa-users mr-2"></i> {{ __('realestate.tenants') }}</h5>
                    <a href="{{ route('tenants.create') }}" class="btn btn-success btn-sm shadow-sm">
                        <i class="fas fa-plus ml-1"></i> {{ __('realestate.add_tenant') }}
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center align-middle">
                            <thead class="thead-light bg-light">
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('realestate.tenant_name') }}</th>
                                    <th>{{ __('realestate.phone') }}</th>
                                    <th>{{ __('realestate.id_number') ?? 'رقم الهوية' }}</th>
                                    <th>{{ __('realestate.nationality') ?? 'الجنسية' }}</th>
                                    <th>{{ __('realestate.address') }}</th>
                                    <th>{{ __('realestate.tax_number') ?? 'الرقم الضريبي' }}</th>
                                    <th>{{ __('realestate.balance') }}</th>
                                    <th>{{ __('realestate.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tenants as $tenant)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
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
                                                <!-- زر العرض -->
                                                <a href="{{ route('tenants.show', $tenant->id) }}" class="btn btn-sm btn-info text-white" title="عرض">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <!-- زر التعديل -->
                                                <a href="{{ route('tenants.edit', $tenant->id) }}" class="btn btn-sm btn-primary" title="تعديل">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <!-- زر الحذف -->
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
                </div>
            </div>
        </div>
    </div>
@endsection