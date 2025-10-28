@extends('layouts.clerk.layout')

@section('title', 'Preparation')

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
        @forelse($resources as $index => $resource)
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
                        <p class="mt-2">
                            <i class="bi bi-box-seam-fill"></i> {{ $resource->warehouse->name }}
                        </p>
                        <i>Remarks:</i> {{ $resource->remark ?? 'N/A'}}
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

                    <!-- Table -->
                    <div class="card-body">
                        <form action="{{route('clerk.resource.prepare.complete', $resource->id)}}" method="POST">
                            @csrf
                            <!-- Resources Table -->
                            <div class="card shadow-sm mt-4">
                                <div class="card-header d-flex justify-content-between align-items-center bg-primary">
                                    <h5 class="mb-0 text-white"
                                        style="cursor:pointer;"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#resourceDetailsModal{{ $index }}">
                                        Resources <i class="bi bi-info-circle"></i>
                                    </h5>

                                    <!-- Details Modal -->
                                    <div class="modal fade" id="resourceDetailsModal{{ $index }}" tabindex="-1" aria-labelledby="resourceDetailsModalLabel{{ $index }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="resourceDetailsModalLabel{{ $index }}">
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
                                    <table class="table table-hover table-striped align-middle text-center mb-0 fw-bold preparationTable">
                                        <thead>
                                            <tr>
                                                <th class="col-1">No.</th>
                                                <th class="col-2">Name</th>
                                                <th class="col-4">Description</th>
                                                <th class="col-1">Quantity</th>
                                                <th class="col-1">Supply</th>
                                                <th class="col-1">Stocks</th>
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
                                                    <!-- Supply -->
                                                    <td>
                                                        <input 
                                                            type="number" 
                                                            class="form-control qty-input" 
                                                            min="0"
                                                            name="supplied[{{$item->id}}]"
                                                            data-success-threshold="{{$item->quantity}}"
                                                            data-stocks-threshold="{{$item->details->stocks}}"
                                                            value="{{$item->supplied}}"
                                                        >
                                                    </td>
                                                    <!-- Stocks -->
                                                    <td>
                                                        {{ $item->details->stocks . ' ' . $item->details->measure}}
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
                            <button type="button" class="btn btn-primary w-100 w-sm-auto"
                                style="cursor:pointer;"
                                data-bs-toggle="modal" 
                                data-bs-target="#driverModal{{ $index }}">
                                Complete Preparation
                            </button>

                            <!-- Details Modal -->
                            <div class="modal fade" id="driverModal{{ $index }}" tabindex="-1" aria-labelledby="driverModalLabel{{ $index }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="driverModalLabel{{ $index }}">
                                                Assign Driver
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <select name="driver_id" id="driver" class="form-control" required>
                                                <option selected disabled>--Driver--</option>
                                                @if($drivers)
                                                    @foreach($drivers as $driver)
                                                        <option 
                                                            @if($resource->driver_id == $driver->id) selected @endif 
                                                            value="{{ $driver->id }}">
                                                            {{$driver->employeeCode().' | '.$driver->email}}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">
                                                Confirm
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty

        @endforelse
    </div>

    
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.preparationTable').DataTable({
                searching: false, // Disables the search input
                paging: false,    // Disables pagination
                info: false       // Optionally, hides the "Showing X of Y entries" info
            });
        });
    </script>
@endpush

@push('scripts')
<script>        
    document.addEventListener('DOMContentLoaded', function () {
            function updateRowColor(input) {
                const tr = input.closest('tr');
                if (!tr) return;
                
                const val = input.value === '' ? null : Number(input.value);
                const success = Number(input.dataset.successThreshold);
                const stocks = Number(input.dataset.stocksThreshold);

                tr.querySelectorAll('td').forEach(td => {
                    td.classList.remove('bg-success', 'bg-warning', 'bg-danger', 'text-white');
                });

                if (val === null) return;

                let classes = [];
                if (val > stocks) {
                    classes = ['bg-danger','text-white'];
                } else if (val === success) {
                    classes = ['bg-success','text-white'];
                } else {
                    classes = ['bg-warning'];
                }

                // apply color to each td
                tr.querySelectorAll('td').forEach(td => {
                    td.classList.add(...classes);
                });
            }
            
            document.querySelectorAll('.qty-input').forEach(function (input) {
                // run function every key press/release
                input.addEventListener('input', function () {
                    updateRowColor(input);
                });

                // run on page load
                updateRowColor(input);
            });
        });
    </script>
@endpush