<div class="table-responsive">
    <div class="flex justify-between mb-3">
        <input
            type="text"
            class="border rounded px-3 py-2 w-1/4 text-sm focus:outline-none focus:ring focus:border-blue-300"
            placeholder="Search items..."
            {{-- wire:model.live.debounce.500ms="search" --}}
            wire:model.live="search"
        >
    </div>

    <!-- Actual Table-->
    <table class="table table-striped table-hover mb-0">
        <thead class="table-dark">
            <tr>
                <th style="width: 60px;">No.</th>
                <th wire:click="sortBy('category')" style="cursor:pointer;">
                    Category
                    @if ($sortField === 'category')
                        <span>{!! $sortDirection === 'asc' ? '&#9650;' : '&#9660;' !!}</span>
                    @endif
                </th>
                <th wire:click="sortBy('name')" style="cursor:pointer;">
                    Name
                    @if ($sortField === 'name')
                        <span>{!! $sortDirection === 'asc' ? '&#9650;' : '&#9660;' !!}</span>
                    @endif
                </th>
                <th wire:click="sortBy('description')" style="cursor:pointer;">
                    Description
                    @if ($sortField === 'description')
                        <span>{!! $sortDirection === 'asc' ? '&#9650;' : '&#9660;' !!}</span>
                    @endif
                </th>
                <th wire:click="sortBy('stocks')" style="cursor:pointer;">
                    Stocks
                    @if ($sortField === 'stocks')
                        <span>{!! $sortDirection === 'asc' ? '&#9650;' : '&#9660;' !!}</span>
                    @endif
                </th>
                <th wire:click="sortBy('cost')" style="cursor:pointer;">
                    Cost
                    @if ($sortField === 'cost')
                        <span>{!! $sortDirection === 'asc' ? '&#9650;' : '&#9660;' !!}</span>
                    @endif
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($warehouse_items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ ucwords($item->category) }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->stocks.' '.$item->measure }}</td>
                    <td class="text-end pe-3">₱{{ number_format($item->cost, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No result found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>