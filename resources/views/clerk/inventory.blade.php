@extends('layouts.clerk.layout')

@section('title', $warehouse->name. ' Inventory')

@section('content')
    <!-- Toast Alert -->
    <div>
        @if (session('success'))
        <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1080;">
            <div id="liveToast" class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        @elseif ($errors->any())
        <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1080;">
            @foreach($errors->all() as $error)
                <div id="liveToastError" class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ $error }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    </div>
    
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h2 class="card-title mb-0 fw-bold">
                    <a href="{{ route('clerk.warehouses') }}"
                        class="text-decoration-none">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    {{ $warehouse->name }}
                </h2>

                <div class="text-end">
                    <span class="badge bg-primary mt-2 fs-5">{{ ucwords($warehouse->status) }}</span>
                </div>
            </div>

            <div class="card-body">
                {{-- Location --}}
                <div class="mb-4 fs-5">
                    <h4 class="fw-bold text-primary">
                        <i class="bi bi-geo-alt"></i> Location
                    </h4>
                    <p class="mb-1">
                        {{ ($warehouse->house . ', ' . $warehouse->zipcode) ?? 'N/A' }}
                    </p>
                    <p class="mb-1">
                        {{ ($warehouse->barangay . ', ' . $warehouse->city . ', ' . $warehouse->province) ?? 'N/A' }}
                    </p>
                </div>
                
                <div class="mb-4 fs-5">
                    {{-- Inventory Clerks --}}
                    <h4 class="fw-bold text-primary">
                        <i class="bi bi-person"></i> Inventory Clerks
                    </h4>
                    @forelse($warehouse->users as $user)
                        <p class="mb-1">
                            <b>{{ $user->name }} </b>
                            <br>
                            {{ $user->employeeCode() }}
                        </p>
                    @empty
                        <p class="mb-1 text-secondary">
                            <i>No user assigned.</i>
                        </p>
                    @endforelse
                </div>
                
                <!-- Resources Table Card -->
                <div class="mt-4" id="resourcesTable">
                    <div class="card-header d-flex justify-content-between align-items-center bg-primary">
                        <h5 class="mb-0 text-white">Resources</h5>
                        <div>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#supplyModal">
                                Batch Supply
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                Batch Delete
                            </button>
                        </div>
                        
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ asset('csv-templates/items-template.csv') }}" class="btn btn-secondary btn-sm">
                                Download CSV Template
                            </a>

                            <label for="csv_file" class="btn btn-success btn-sm">Upload CSV File</label>
                            
                            <form action="{{ route('clerk.inventory.upload', $warehouse->id) }}" 
                                method="POST" 
                                enctype="multipart/form-data" 
                                id="csvUploadForm">

                                @csrf
                                <input type="file" class="d-none" id="csv_file" name="csv_file" accept=".csv,.txt" required 
                                    onchange="this.form.submit()">
                            </form>
                        </div>
                        <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addItemModal">
                            Add Item
                        </button>

                        <!-- Add Item Modal -->
                        <div class="modal fade resettable-modal" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="{{ route('clerk.inventory.item.add', $warehouse->id) }}" method="POST">
                                        @csrf

                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="addItemModalLabel">
                                                Add Item
                                            </h5>

                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <!-- Material -->
                                            <div class="mt-4">
                                                <label for="category" class="form-label fw-bold">Category</label>
                                                <select name="category" id="category" class="form-control" required>
                                                    <option value="material" {{ old('category') == 'material' ? 'selected' : ''}}>
                                                        Material
                                                    </option>

                                                    <option value="tool" {{ old('category') == 'tool' ? 'selected' : ''}}>
                                                        Tool
                                                    </option>
                                                </select>
                                            </div>
                                            
                                            <!-- Name -->
                                            <div class="mt-4">
                                                <label for="name" class="form-label fw-bold">Name</label>
                                                <input value="{{ old('name') }}" required type="text" name="name" id="name" class="form-control">
                                            </div>

                                            <!-- Description -->
                                            <div class="col-12 mt-4">
                                                <label for="description" class="form-label fw-bold">Description</label>
                                                <textarea required name="description" id="description" class="form-control" rows="4"
                                                >{{ old('description') }}</textarea>
                                            </div>

                                            <!-- Cost -->
                                            <div class="mt-4">
                                                <label for="cost" class="form-label fw-bold">Cost</label>
                                                <input value="{{ old(key: 'cost') }}" required type="number" name="cost" id="cost" class="form-control">
                                            </div>
                                            
                                            <!-- Measure -->
                                            <div class="mt-4">
                                                <label for="measure" class="form-label fw-bold">Measurement</label>
                                                <input value="{{ old('measure') }}" required type="text" name="measure" id="measure" class="form-control">
                                            </div>

                                            <!-- Stocks -->
                                            <div class="mt-4">
                                                <label for="stocks" class="form-label fw-bold">Stocks</label>
                                                <input value="{{ old('stocks') }}" required type="number" name="stocks" id="stocks" class="form-control">
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button onclick="this.disabled=true;this.form.submit()"
                                                type="submit" class="btn btn-success">Add Item</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Display Resources Table / Buttons  -->
                    <div class="table-responsive">  
                        <table @if($items->isNotEmpty()) id="resourceTable" @endif class="table table-hover table-striped align-middle text-center mb-0">
                            <thead class="table-dark text-white">
                                <tr>
                                    <th class="col-1">No.</th>
                                    <th class="col-2">Name</th>
                                    <th class="col-4">Description</th>
                                    <th class="col-1">Cost</th>
                                    <th class="col-1">Stocks</th>
                                    <th class="col-1">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td class="text-start">
                                            @if($item->category === 'material')
                                                <i class="bi bi-box"></i>
                                            @else
                                                <i class="bi bi-wrench"></i>
                                            @endif
                                            {{ $item->name }}
                                        </td>
                                        <td class="text-start">{{ $item->description }}</td>
                                        <td class="text-end pe-3">₱{{ $item->cost }}</td>
                                        <td> {{ $item->stocks.' '.$item->measure }} </td>
                                        <td>
                                            <a href="{{ route('clerk.inventory.item.edit', $item->id) }}"
                                            class="btn btn-primary">Edit</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No items.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{-- <div class="d-flex justify-content-center">
                            {{ $items->links() }}
                        </div> --}}
                    </div>


                    <!-- Modal for Batch Supply -->
                    <div class="modal fade resettable-modal" id="supplyModal" tabindex="-1" aria-labelledby="supplyModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="{{ route('clerk.inventory.supply') }}" method="POST">
                                    @csrf @method('PUT')

                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="editModalLabel">Supply Stocks</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <!-- Modal Table -->
                                            <table class="table table-hover mb-0">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th class="col-1">No.</th>
                                                        <th class="col-2">Name</th>
                                                        <th class="col-4">Description</th>
                                                        <th class="col-1">Cost</th>
                                                        <th class="col-1">Stocks</th>
                                                        <th class="col-1">Supply</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($items as $item_index => $item)
                                                        <tr>
                                                            <td>{{ $item_index + 1 }}</td>
                                                            <td class="text-start">
                                                                @if($item->category === 'material')
                                                                    <i class="bi bi-box"></i>
                                                                @else
                                                                    <i class="bi bi-wrench"></i>
                                                                @endif
                                                                {{ $item->name }}
                                                            </td>
                                                            <td class="text-start">{{ $item->description }}</td>
                                                            <td>₱{{ number_format($item->cost, 2) }}</td>
                                                            <td>{{ $item->stocks.' '.$item->measure }}</td>
                                                            <td class="col-1">
                                                                <input type="number" name="inventory_items[{{ $item->id }}]"
                                                                    value=""
                                                                    class="form-control form-control-sm" min="1">
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-center text-muted">No resources.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button onclick="this.disabled=true;this.form.submit()"
                                            type="submit" class="btn btn-success">Supply</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Batch Delete -->
                    <div class="modal fade resettable-modal" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="{{ route('clerk.inventory.delete') }}" method="POST">
                                    @csrf @method('DELETE')
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="deleteModalLabel">Delete Items</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <!-- Modal Table -->
                                            <table class="table table-hover mb-0">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th class="col-1">No.</th>
                                                        <th class="col-2">Name</th>
                                                        <th class="col-4">Description</th>
                                                        <th class="col-1">Cost</th>
                                                        <th class="col-1">Stocks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($items as $item_index => $item)
                                                        <tr onclick="toggleRemove(this)">
                                                            <td class="d-none">
                                                                <input type="checkbox" name="inventory_items[]"
                                                                    value="{{ $item->id }}">
                                                            </td>
                                                            <td>{{ $item_index + 1 }}</td>
                                                            <td class="text-start">
                                                                @if($item->category === 'material')
                                                                    <i class="bi bi-box"></i>
                                                                @else
                                                                    <i class="bi bi-wrench"></i>
                                                                @endif
                                                                {{ $item->name }}
                                                            </td>
                                                            <td class="text-start">{{ $item->description }}</td>
                                                            <td>₱{{ number_format($item->cost, 2) }}</td>
                                                            <td>{{ $item->stocks.' '.$item->measure }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-center text-muted">No resources added
                                                                yet</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">Remove</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleSelect(row) {
            const checkbox = row.querySelector('input[type=checkbox]');
            checkbox.checked = !checkbox.checked;
            row.classList.toggle('table-primary', checkbox.checked);
        }

        function toggleRemove(row) {
            const checkbox = row.querySelector('input[type=checkbox]');
            checkbox.checked = !checkbox.checked;
            row.querySelectorAll('td').forEach(td => {
                td.classList.toggle('bg-danger', checkbox.checked);
                td.classList.toggle('text-white', checkbox.checked);
            });
        }

        // Batch Supply Modal
        document.getElementById('supplyModal').addEventListener('hidden.bs.modal', function () {
            this.querySelectorAll('input[type="number"]').forEach(inp => inp.value = null);
        });

        // Batch Delete Modal
        document.getElementById('deleteModal').addEventListener('hidden.bs.modal', function () {
            this.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
            this.querySelectorAll('td.bg-danger').forEach(td => td.classList.remove('bg-danger','text-white'));
        });

    </script>
@endpush