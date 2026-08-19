{{-- partials/listings-results.blade.php --}}
{{-- هذا الجزء يُعاد استخدامه في التحميل الأول للصفحة وأيضًا كرد AJAX عند البحث --}}

<div class="d-flex justify-content-between align-items-center px-3 py-3 border-bottom">
    <span class="font-weight-bold"><i class="fas fa-list text-primary ml-1"></i> {{ __('dashboard.results_title') }}</span>
    <span class="text-muted" style="font-size:0.85rem;">{{ __('dashboard.results_count', ['count' => ($availableListings ?? collect())->count()]) }}</span>
</div>

@if(($availableListings ?? collect())->count())
    <div class="table-responsive">
        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th>{{ __('dashboard.table_name') }}</th>
                    <th>{{ __('dashboard.table_type') }}</th>
                    <th>{{ __('dashboard.table_location') }}</th>
                    <th>{{ __('dashboard.table_unit_category') }}</th>
                    <th>{{ __('dashboard.table_price') }}</th>
                    <th>{{ __('dashboard.table_available_units') }}</th>
                    <th>{{ __('dashboard.table_status') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($availableListings as $listing)
                    <tr class="{{ $listing->type === 'rent' ? 'listing-row-rent' : 'listing-row-sale' }}">
                        <td class="font-weight-bold">{{ $listing->name }}</td>
                        <td>
                            @if($listing->type === 'rent')
                                <span class="badge-type-rent">{{ __('dashboard.filter_for_rent') }}</span>
                            @else
                                <span class="badge-type-sale">{{ __('dashboard.filter_for_sale') }}</span>
                            @endif
                        </td>
                        <td>{{ $listing->city }} @if($listing->district) — {{ $listing->district }} @endif</td>
                        <td>{{ $listing->property_category }}</td>
                        <td>
                            @if($listing->type === 'rent')
                                {{ $listing->annual_rent ? __('dashboard.price_per_year', ['price' => number_format($listing->annual_rent, 2)]) : __('dashboard.no_price') }}
                            @else
                                {{ $listing->sale_price ? __('dashboard.price_total', ['price' => number_format($listing->sale_price, 2)]) : __('dashboard.no_price') }}
                            @endif
                        </td>
                        <td>
                            @if($listing->type === 'rent')
                                {{ (int) $listing->units_total > 0 ? __('dashboard.units_of_total', ['available' => $listing->units_available, 'total' => $listing->units_total]) : __('dashboard.not_available') }}
                            @else
                                {{ __('dashboard.not_available') }}
                            @endif
                        </td>
                        <td>
                            @if($listing->is_available)
                                <span class="badge-available">{{ __('dashboard.status_available') }}</span>
                            @else
                                <span class="badge-unavailable">{{ __('dashboard.status_unavailable') }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="empty-state"><i class="fas fa-search"></i> {{ __('dashboard.results_empty') }}</div>
@endif