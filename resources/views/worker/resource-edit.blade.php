@extends('layouts.worker.layout')

@section('title', 'Project Resource (Edit)')

@section('content')
    <div class="container mt-5 fs-5">
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

        <div class="card shadow-sm mb-4">
            {{-- Header --}}
            <div class="card-header d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="card-title mb-0 fw-bold">
                        {{ $resource->project->project_name }}

                        <!-- Button trigger modal -->
                        <i class="bi bi-info-circle text-primary"
                            style="cursor:pointer;"
                            data-bs-toggle="modal" 
                            data-bs-target="#resourceDetailsModal">
                        </i>
                    </h2>
                    
                    <!-- Details Modal -->
                    <div class="modal fade" id="resourceDetailsModal" tabindex="-1" aria-labelledby="resourceDetailsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="resourceDetailsModal">
                                        Project Details
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <!-- Project Details Modal -->
                                <div class="modal-body">
                                    {{-- Project Overview --}}
                                    <h4 class="fw-bold text-primary">
                                        <i class="bi bi-box-seam"></i> Project Overview
                                    </h4>
                                    <p class="mb-5 text-muted">{{ $resource->project->description ?? 'No description provided' }}</p>

                                    {{-- Location --}}
                                    <h4 class="fw-bold text-primary">
                                        <i class="bi bi-geo-alt"></i> Location
                                    </h4>
                                    <p class="mb-1">{{
                                        ($resource->project->house.', '.$resource->project->zipcode)
                                        ?? 'N/A' }}
                                    </p>
                                    <p class="mb-5">{{ 
                                        ($resource->project->province.', '.$resource->project->city.', '.$resource->project->barangay) 
                                        ?? 'N/A' }}
                                    </p>

                                    {{-- Project Owner --}}
                                    <h4 class="fw-bold text-primary">
                                        <i class="bi bi-person"></i> Project Owner
                                    </h4>
                                    <p class="mb-1"><strong>Name:</strong> {{ $resource->project->owner->name ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>Phone:</strong> {{ $resource->project->owner->contact_number ?? 'N/A' }}</p>
                                    <p class="mb-5"><strong>Email:</strong> {{ $resource->project->owner->email ?? 'N/A' }}</p>

                                    {{-- Assigned --}}
                                    <h4 class="fw-bold text-primary">
                                        <i class="bi bi-check2-circle"></i> Assigned
                                    </h4>
                                    <p class="mb-1"><strong>Worker:</strong> {{ $resource->project->worker->name ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>ID:</strong> {{ $resource->project->worker->employeeCode() ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <!-- Project status badges -->
                    <span class="badge bg-secondary fs-5">{{ ucfirst($resource->status) }}</span>
                </div>
            </div>

            {{-- Body --}}
            <div class="card-body">
                <div class="tab-pane fade show @if(session('active_tab') == $resource->id) active @endif" id="resource" role="tabpanel">
                    <form id="projectForm" action="" method="POST">
                        @csrf @method('PUT')

                        <!-- Created at -->
                        <div class="col-12 mt-4">
                            <h5 class="fw-bold">Created at:</h5>
                            <p>
                                {{ $resource->created_at->format('Y-m-d') }}
                            </p>
                        </div>

                        <!-- Schedule -->
                        <div class="mt-4">
                            <label for="schedule" class="form-label fw-bold">Date Needed:</label>
                            <input type="date" name="schedule" id="schedule" class="form-control"
                                value="{{  optional($resource->schedule)->format('Y-m-d') }}">
                        </div>

                        <!-- Remarks -->
                        <div class="col-12 mt-4">
                            <label for="remark" class="form-label fw-bold">Remarks</label>
                            <textarea name="remark" id="remark" class="form-control" rows="1"
                                placeholder="">{{ $resource->remark ?? ''}}</textarea>
                        </div>

                        <!-- Resources Table Card -->
                        <div class="card shadow-sm mt-4" id="resourcesTable">
                            <div
                                class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                                <h5 class="mb-0">Resources</h5>
                                <div>
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#editModal">
                                        Batch Edit
                                    </button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal">
                                        Batch Delete
                                    </button>
                                </div>
                                <a class="btn btn-light"
                                    href="{{ route('worker.resource_item.add', $resource->id) }}">
                                    Add Items
                                </a>
                            </div>

                            <!-- Display Resources Table / Buttons  -->
                            <div class="card-body p-0">

                                <!-- Display Table -->
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped align-middle text-center mb-0">
                                        <thead class="table-dark text-white">
                                            <tr>
                                                <th class="col-1">No.</th>
                                                <th class="col-2">Name</th>
                                                <th class="col-4">Description</th>
                                                <th class="col-1">Quantity</th>
                                                <th class="col-1">Cost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($resource->items as $index2 => $item)
                                                <tr>
                                                    <td>{{ $index2 + 1 }}</td>
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
                                                    <td class="text-end pe-3">
                                                        ₱{{ number_format($item->details->cost * $item->quantity, 2) }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">No resources added yet</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                        @if($resource->items->isNotEmpty())
                                        <tfoot class="table-light fw-bold">
                                            <tr>
                                                <td colspan="3"></td>
                                                <td>Total:</td>
                                                <td class="text-end pe-3">₱{{ number_format($resource->items->sum(
                                                    fn($item) =>
                                                    $item->details->cost * $item->quantity
                                                ), 2) }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                        @endif
                                    </table>
                                </div>

                                <!-- Buttons -->
                                <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 p-3">
                                    
                                    <!-- Back Button -->
                                    <a href="{{ route('worker.project.view', $resource->id) }}"
                                        class="btn btn-secondary w-100 w-sm-auto">Back</a>
                                    
                                    <!-- Save Button -->
                                    <button
                                        formaction="{{ route('worker.resource.update', ['resource_id' => $resource->id, 'submit' => 'false']) }}"
                                        type="submit" id="btnSave" class="btn btn-primary w-100 w-sm-auto">
                                        Save
                                    </button>
                                    
                                    <!-- Request Button -->
                                    <button
                                        formaction="{{ route('worker.resource.update', ['resource_id' => $resource->id, 'submit' => 'true']) }}"
                                        type="submit" id="btnRequest" class="btn btn-success w-100 w-sm-auto">
                                        Request
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Modal for Batch Edit -->
                    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form action="{{ route('worker.resource_item.update', [
                                                                                'resource_id' => $resource->id,
                                                                            ]) }}" method="POST">
                                    @csrf @method('PUT')

                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="editModalLabel">Update Resources</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <!-- Modal Table -->
                                            <table class="table table-hover mb-0">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Name</th>
                                                        <th>Description</th>
                                                        <th>Cost Each</th>
                                                        <th>Quantity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($resource->items as $item_index => $item)
                                                        <tr>
                                                            <td>{{ $item_index + 1 }}</td>
                                                            <td class="text-start">
                                                                @if($item->details->category === 'material')
                                                                    <i class="bi bi-box"></i>
                                                                @else
                                                                    <i class="bi bi-wrench"></i>
                                                                @endif
                                                                {{ $item->details->name }}
                                                            </td>
                                                            <td class="text-start">{{ $item->details->description }}</td>
                                                            <td>₱{{ number_format($item->details->cost, 2) }}</td>
                                                            <td class="col-1">
                                                                <input type="number" name="resource_items[{{ $item->id }}]"
                                                                    value="{{ $item->quantity }}"
                                                                    class="form-control form-control-sm" min="1">
                                                            </td>
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
                                        <button type="submit" class="btn btn-success">Update</button>
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
                                <form action="{{ route('worker.resource_item.delete', $resource->id) }}" method="POST">
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
                                                        <th>No.</th>
                                                        <th>Name</th>
                                                        <th>Description</th>
                                                        <th class="text-center">Quantity</th>
                                                        <th class="text-center">Cost</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($resource->items as $item_index => $item)
                                                        <tr onclick="toggleRemove(this)">
                                                            <td class="d-none">
                                                                <input type="checkbox" name="resource_items[]"
                                                                    value="{{ $item->id }}">
                                                            </td>
                                                            <td>{{ $item_index + 1 }}</td>
                                                            <td class="text-start">
                                                                @if($item->details->category === 'material')
                                                                    <i class="bi bi-box"></i>
                                                                @else
                                                                    <i class="bi bi-wrench"></i>
                                                                @endif
                                                                {{ $item->details->name }}
                                                            </td>
                                                            <td class="text-start">{{ $item->details->description }}</td>
                                                            <td class="col-1 text-center">
                                                                {{ $item->quantity . ' ' . $item->details->measure }}
                                                            </td>
                                                            <td class="text-end pe-3">
                                                                ₱{{ number_format($item->details->cost * $item->quantity, 2) }}
                                                            </td>
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
    </div>

    <script>
        function toggleRemove(row) {
            const checkbox = row.querySelector('input[type=checkbox]');
            checkbox.checked = !checkbox.checked;
            row.querySelectorAll('td').forEach(td => {
                td.classList.toggle('bg-danger', checkbox.checked);
                td.classList.toggle('text-white', checkbox.checked);
            });
        }
    </script>
@endsection