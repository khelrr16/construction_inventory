@extends('layouts.worker.layout')

@section('title', 'Project Resource Verify')

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
    
    <div class="container mt-5 fs-5">        
        <div class="card shadow-sm mb-4">
            {{-- Header --}}
            <div class="card-header d-flex justify-content-between align-items-start"
                data-bs-toggle="collapse" 
                data-bs-target="#resource" 
                aria-expanded="false" 
                aria-controls="resource" 
                style="cursor: pointer;">

                <div>
                    <h2 class="card-title mb-0 fw-bold">
                        {{ $resource->project->project_name }} 
                        <span class="badge bg-warning mt-2 fs-5">{{ ucwords($resource->status) }}</span>
                    </h2>
                    <p class="mt-2"><i>Remarks:</i> {{ $resource->remark ?? 'N/A'}} </p>

                </div>
                <div class="text-end">
                    <span class="text-danger fw-bold">
                        <i class="bi bi-calendar-event"></i>
                        {{ ($resource->schedule->format('m/d/Y')) ?? 'N/A' }}
                    </span>
                    <span class="text-muted d-block">Date Needed:</span>

                    <span class="text-secondary fw-bold mt-3 d-block">
                        <i class="bi bi-calendar-event"></i>
                        {{ ($resource->updated_at->format('m/d/Y')) ?? 'N/A' }}
                    </span>
                    <span class="text-muted d-block">Date Requested:</span>
                </div>
            </div>

            <div id="resource" class="collapse">
                <div class="card-body">
                    @php $project = $resource->project @endphp
                    @include('parts.details.project-details')
                </div>
            </div>

            <!-- Table -->
            <div class="card-body">
                <form action="{{route('worker.resource.verify.complete', $resource->id)}}" method="POST">
                    @csrf @method('PUT')
                    <!-- Resources Table -->
                        <div class="card shadow-sm mt-4">
                            <div class="card-header d-flex justify-content-between align-items-center bg-primary">
                                <h5 class="mb-0 text-white"
                                    style="cursor:pointer;"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#resourceDetailsModal">
                                    Resource <i class="bi bi-info-circle"></i>
                                </h5>

                            <!-- Details Modal -->
                            <div class="modal fade" id="resourceDetailsModal" tabindex="-1" aria-labelledby="resourceDetailsModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="resourceDetailsModal">
                                                Resource Details
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            @include('parts.details.resource-details')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Display Table -->
                        <div class="table-responsive p-3">
                            <table class="table table-hover table-striped align-middle text-center mb-0" id="verifyTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="col-1">No.</th>
                                        <th class="col-2">Name</th>
                                        <th class="col-4">Description</th>
                                        <th class="col-1">Quantity</th>
                                        <th class="col-1">Completed</th>
                                        <th class="col-1">Missing</th>
                                        <th class="col-1">Broken</th>
                                        <th class="col-1">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($resource->items as $item_index => $item)
                                        <tr>
                                            <!-- No. -->
                                            <td>{{ $item_index + 1 }}</td>
                                            <!-- Name -->
                                            <td class="text-start">
                                                @if($item->details->category === 'material')
                                                    <i class="bi bi-box"></i>
                                                @else
                                                    <i class="bi bi-wrench"></i>
                                                @endif
                                                {{ $item->details->name }}
                                            </td>
                                            <!-- Description -->
                                            <td class="text-start">{{ $item->details->description }}</td>
                                            <!-- Quantity -->
                                            <td>
                                                {{ $item->quantity . ' ' . $item->details->measure}}
                                            </td>

                                            <!-- Completed -->
                                            <td>
                                                <input 
                                                    type="number" 
                                                    class="form-control qty-input" 
                                                    min="0"
                                                    name="completed[{{$item->id}}]"
                                                    data-success-threshold="{{$item->quantity}}"
                                                    value="{{ old('completed.'.$item->id) }}"
                                                >
                                            </td>

                                            <!-- Missing -->
                                            <td>
                                                <input 
                                                    type="number" 
                                                    class="form-control qty-input" 
                                                    min="0"
                                                    name="missing[{{$item->id}}]"
                                                    data-success-threshold="{{$item->quantity}}"
                                                    value="{{ old('missing.'.$item->id) }}"
                                                >
                                            </td>

                                            <!-- Broken -->
                                            <td>
                                                <input 
                                                    type="number" 
                                                    class="form-control qty-input" 
                                                    min="0"
                                                    name="broken[{{$item->id}}]"
                                                    data-success-threshold="{{$item->quantity}}"
                                                    value="{{ old( 'broken.'.$item->id) }}"
                                                >
                                            </td>
                                            <!-- Status -->
                                            <td>
                                                <x-status-badge status="{{ $item->status }}" class="fs-5" />
                                            </td>
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
                                            <td class="text-end pe-3">₱{{ number_format($resource->items->sum(fn($item) => $item->details->cost * $item->quantity), 2) }}</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>

                    <!-- Button trigger modal -->
                    <button type="submit" class="btn btn-primary w-100 w-sm-auto">
                        Complete Verification
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#verifyTable').DataTable({
                searching: false, // Disables the search input
                paging: false,    // Disables pagination
                info: false       // Optionally, hides the "Showing X of Y entries" info
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const rows = document.querySelectorAll('tr');

            rows.forEach(row => {
                const inputs = row.querySelectorAll('.qty-input');

                if (inputs.length > 0) {
                    const threshold = Number(inputs[0].dataset.successThreshold);

                    // Define a reusable function to update row color
                    const updateRowStatus = () => {
                        let total = 0;
                        let classes = [];

                        inputs.forEach(i => total += Number(i.value || 0));

                        // Remove previous color classes
                        row.querySelectorAll('td').forEach(td => {
                            td.classList.remove('bg-success', 'bg-danger', 'text-white');
                        });

                        // Compare total vs threshold
                        if (total > threshold) {
                            classes = ['bg-danger', 'text-white'];
                        } else if (total === threshold) {
                            classes = ['bg-success', 'text-white'];
                        }

                        // Apply new classes
                        if (classes.length) {
                            row.querySelectorAll('td').forEach(td => td.classList.add(...classes));
                        }
                    };

                    // Attach input listeners
                    inputs.forEach(input => input.addEventListener('input', updateRowStatus));

                    // ✅ Execute once after page load
                    updateRowStatus();
                }
            });
        });
    </script>
@endpush