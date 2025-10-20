<div class="table-responsive p-3">
    <div class="flex justify-between mb-3">
        <input
            type="text"
            class="border rounded px-3 py-2 w-1/4 text-sm focus:outline-none focus:ring focus:border-blue-300"
            placeholder="Search items..."
            {{-- wire:model.live.debounce.500ms="search" --}}
            wire:model.live="search"
        >
        
        @if(count($selectedItems) > 0)
            <button 
                type="button"
                wire:click="clearSelections" 
                class="btn btn-secondary"
            >
                Clear Selections
            </button>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectedModal">
                Selected Items: ({{ count($selectedItems) }})
            </button>
        @endif
    </div>

    <!-- Actual Table-->
    <table class="table table-striped table-hover mb-0">
        <thead class="table-dark">
            <tr>
                <th width="50px">Select</th>
                <th width="60px">No.</th>
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
                <th wire:click="sortBy('measure')" style="cursor:pointer;">
                    Measure
                    @if ($sortField === 'measure')
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
            @forelse($items as $index => $item)
                <tr class="{{ in_array($item->id, $selectedItems) ? 'table-primary' : '' }}"
                    wire:key="row-{{ $item->id }}"
                    wire:click="toggleItem({{ $item->id }})"
                    style="cursor: pointer;"
                >
                    <td>
                        <input 
                            type="checkbox"
                            wire:change="toggleItem({{ $item->id }})"
                            {{ in_array($item->id, $selectedItems) ? 'checked' : '' }}
                            class="form-check-input"
                        >
                    </td>
                    <td>{{ $index + 1}}</td>
                    <td>
                        @if($item->category === 'material')
                            <i class="bi bi-box"></i>
                        @else
                            <i class="bi bi-wrench"></i>
                        @endif
                        {{ $item->name }}
                    </td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->measure }}</td>
                    <td>₱{{ number_format($item->cost, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No result found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Bootstrap 5 Modal -->
    <div class="modal fade" id="selectedModal" tabindex="-1" aria-labelledby="selectedModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selectedModalLabel">Selected Items ({{ count($selectedItems) }})</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if(count($selectedItems) > 0)
                        <!-- Selected Items Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="60px">No.</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Measure</th>
                                        <th>Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($selectedItemModels as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @if($item->category === 'material')
                                                    <i class="bi bi-box"></i>
                                                @else
                                                    <i class="bi bi-wrench"></i>
                                                @endif
                                                {{ $item->name }}
                                            </td>
                                            <td>{{ $item->description }}</td>
                                            <td>{{ $item->measure }}</td>
                                            <td>₱{{ number_format($item->cost, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            No items selected
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    
                    <button type="button" 
                            class="btn btn-primary" 
                            wire:click="addItemsToResource({{ $resource->id }})"
                            wire:loading.attr="disabled"
                            @if(count($selectedItems) === 0) disabled @endif>
                        Add Items
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>