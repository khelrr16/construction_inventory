@extends('layouts.others.layout')

@section('title', 'Title')

@section('content')
    <div class="container">
        <!-- Alert -->
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
        @elseif (session('error'))
        <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1080;">
            <div id="liveToastError" class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Resources Table Card -->
        <div class="card shadow-sm mt-4" id="resourcesTable">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                <h5 class="mb-0">Resources</h5>
                <div>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#supplyModal">
                        Batch Supply
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        Batch Delete
                    </button>
                </div>
                
                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#resourceModal">
                    Add Items
                </button>
            </div>

            <!-- Display Resources Table / Buttons  -->
            <div class="table-responsive">  
                <table class="table table-hover table-striped align-middle text-center mb-0">
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
                                <td><a class="btn btn-primary">Edit</a></td>
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
            <div class="modal fade" id="supplyModal" tabindex="-1" aria-labelledby="supplyModalLabel"
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
                                                        <input type="number" name="inventory_item[{{ $item->id }}]"
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
                                <button type="submit" class="btn btn-success">Supply</button>
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal for Batch Delete -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="" method="POST">
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
                                                        <input type="checkbox" name="resource_items[]"
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

            // Uncheck all checkboxes inside the modal
            this.querySelectorAll('input[type="number"]').forEach(inp => inp.value = null);
        });

        // Batch Delete Modal
        document.getElementById('deleteModal').addEventListener('hidden.bs.modal', function () {

            // Uncheck all checkboxes inside the modal
            this.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);

            // Also remove any "active" highlight if your toggleRemove() adds one
            this.querySelectorAll('td.bg-danger').forEach(td => td.classList.remove('bg-danger','text-white'));
        });

    </script>
@endsection