@extends('layouts.master')

@section('title')
{{ __('realestate.contracts') }}
@endsection

@section('content')
<br>
<div class="row justify-content-center">
    <div class="col-md-11">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 text-primary"><i class="fas fa-file-contract mr-2"></i>
                    {{ __('realestate.contracts_list') }}</h5>
                <a href="{{ route('lease_contracts.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> {{ __('realestate.new_contract') }}
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center align-middle">
                        <thead class="thead-light bg-light">
                            <tr>
                                <th>#</th>
                                <th>{{ __('realestate.property_and_unit') }}</th>
                                <th>{{ __('realestate.tenant') }}</th>
                                <th>{{ __('realestate.start_date') }}</th>
                                <th>{{ __('realestate.end_date') }}</th>
                                <th>{{ __('realestate.rent_amount') }}</th>
                                <th>{{ __('realestate.status') }}</th>
                                <th>{{ __('realestate.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contracts as $contract)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-weight-bold">
                                    {{ $contract->unit->property->name ?? '' }} -
                                    ({{ $contract->unit->unit_number ?? '' }})
                                </td>
                                <td>{{ $contract->tenant->name ?? '-' }}</td>
                                <td>{{ $contract->start_date }}</td>
                                <td>{{ $contract->end_date }}</td>
                                <td class="text-success font-weight-bold">{{ number_format($contract->rent_amount, 2) }}
                                </td>
                                <td>
                                    @php
                                    $isExpired = \Carbon\Carbon::parse($contract->end_date)->isPast();
                                    @endphp
                                    <span
                                        class="badge {{ !$isExpired  ? 'bg-success' : 'bg-secondary' }} text-white">
                                        {{ !$isExpired  ? __('realestate.active') : __('realestate.expired') }}
                                    </span>
                                <td>
                                    {{-- زر المعاينة --}}
                                    <a href="{{ route('lease_contracts.show', $contract->id) }}"
                                        class="btn btn-sm btn-primary" title="معاينة العقد">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- زر التعديل --}}
                                    <a href="{{ route('lease_contracts.edit', $contract->id) }}"
                                        class="btn btn-sm btn-info text-white" title="تعديل العقد">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-muted py-4">{{ __('realestate.no_contracts') }}</td>
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