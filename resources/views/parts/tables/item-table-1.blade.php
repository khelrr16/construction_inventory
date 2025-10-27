<div class="table-responsive p-3">
    <table @if($warehouse->items->isNotEmpty()) id="resourceTable" @endif
        class="table table-hover table-striped align-middle text-center mb-0">
        <thead class="table-dark">
            <tr>
                <th width="10px">No.</th>
                <th class="col-1">Category</th>
                <th class="col-2">Name</th>
                <th width="200px">Description</th>
                <th width="10px">Stocks</th>
                <th class="col-1">Cost</th>
            </tr>
        </thead>
        <tbody>
            @forelse($warehouse->items as $warehouse_item_index => $item)
                <tr>
                    <td>{{ $warehouse_item_index + 1 }}</td>
                    <td class="text-start">
                        {{ ucwords($item->category) }}
                    </td>
                    <td class="">
                        {{ $item->name}}
                    </td>
                    <td class="text-start">{{ $item->description }}</td>
                    <td>
                        {{ $item->quantity . ' ' . $item->measure}}
                    </td>
                    <td class="text-end pe-3">
                        {{ $item->cost}}
                    </td>
                </tr>
            @empty
                <td colspan="6" class="text-center text-muted">No resources added yet</td>
            @endforelse
        </tbody>
    </table>
</div>