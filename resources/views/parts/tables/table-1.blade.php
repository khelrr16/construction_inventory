<div class="table-responsive p-3">
    <table class="table table-hover table-striped align-middle text-center mb-0
        @if($resource->items->isNotEmpty()) resourceTable @endif">
        
        <thead class="table-dark">
            <tr>
                <th class="col-1">No.</th>
                <th class="col-1">Name</th>
                <th class="col-4">Description</th>
                <th class="col-1">Quantity</th>
                @if(in_array($resource->status, ['incomplete', 'received']))
                    <th class="col-1">Complete</th>
                    <th class="col-1">Missing</th>
                    <th class="col-1">Broken</th>
                @endif
                <th class="col-1">Cost</th>
                <th class="col-1">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($resource->items as $resource_item_index => $item)
                <tr>
                    <td>{{ $resource_item_index + 1 }}</td>
                    <td class="text-start">
                        @if($item->details->category === 'material')
                            <i class="bi bi-box"></i>
                        @else
                            <i class="bi bi-wrench"></i>
                        @endif
                        {{ $item->details->name }}
                    </td>
                    <td class="text-start">{{ $item->details->description }}</td>
                    <td>
                        {{ $item->quantity . ' ' . $item->details->measure}}
                    </td>
                    
                    @if(in_array($resource->status, ['incomplete', 'received']))
                        <td class="col-1">{{ $item->completed ?? '0' }}</td>
                        <td class="col-1">{{ $item->missing ?? '0' }}</td>
                        <td class="col-1">{{ $item->broken ?? '0' }}</td>
                    @endif
                    
                    <td class="text-end pe-3">
                        ₱{{ number_format($item->details->cost * $item->quantity, 2) }}</td>
                    <td>
                        <x-status-badge status="{{ $item->status }}" class="fs-5" />
                    </td>
                </tr>
            @empty
                <td colspan="6" class="text-center text-muted">No resources added yet</td>
            @endforelse
        </tbody>
        @if($resource->items->isNotEmpty())
            <tfoot class="table-light fw-bold">
                <tr>
                    @if(in_array($resource->status, ['incomplete', 'received']))
                        <td colspan="3"></td>
                        <td class="text-end pe-3">Total:</td>
                        <td class="text-center">{{ number_format($resource->items->sum(fn($item) => $item->completed)) }}</td>
                        <td class="text-center">{{ number_format($resource->items->sum(fn($item) => $item->missing)) }}</td>
                        <td class="text-center">{{ number_format($resource->items->sum(fn($item) => $item->broken)) }}</td>
                        <td class="text-end pe-3">₱{{ number_format($resource->items->sum(fn($item) => $item->details->cost * $item->quantity), 2) }}</td>
                    @else
                        <td colspan="3"></td>
                        <td>Total:</td>
                        <td class="text-end pe-3">₱{{ number_format($resource->items->sum(fn($item) => $item->details->cost * $item->quantity), 2) }}</td>
                        <td></td>
                    @endif
                </tr>
            </tfoot>
        @endif
    </table>
</div>