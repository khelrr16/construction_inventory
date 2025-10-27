@extends('layouts.driver.layout')

@section('title', 'Title')

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
                    data-bs-target="#resource-{{ $index }}"
                    aria-expanded="false"
                    aria-controls="resource-{{ $index }}"
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

                {{-- Body --}}
                <div id="resource-{{ $index }}" class="collapse">
                    <div class="card-body">
                        @php $project = $resource->project @endphp
                        @include('parts.details.project-details')

                        <div class="card-body p-0">
                            <!-- Resources Table -->
                            <div class="card shadow-sm mt-4">
                                <div class="card-header d-flex justify-content-between align-items-center bg-primary">
                                    <!-- Button trigger modal -->
                                    <h5 class="mb-0 text-white"
                                        style="cursor:pointer;"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#resourceDetailsModal{{ $index }}">
                                        Resource <i class="bi bi-info-circle"></i>
                                    </h5>

                                    <!-- Details Modal -->
                                    <div class="modal fade" id="resourceDetailsModal{{ $index }}" tabindex="-1" aria-labelledby="resourceDetailsModalLabel{{ $index }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="resourceDetailsModal{{ $index }}">
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
                                @include('parts.tables.table-1')
                            </div>

                            <button class="btn btn-success w-100 w-sm-auto"
                                type="button"
                                style="cursor:pointer;"
                                data-bs-toggle="modal" 
                                data-bs-target="#startDeliveryModal{{ $index }}">
                                Start Delivery
                            </button>

                            <!-- Delivery Modal -->
                            <div class="modal fade" id="startDeliveryModal{{ $index }}" tabindex="-1" aria-labelledby="startDeliveryModalLabel{{ $index }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form action="{{route('driver.delivery.start', $resource->id)}}"
                                            method="POST">
                                            @csrf @method('PUT')
                                            
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="startDeliveryModalLabel{{ $index }}">
                                                    Choose Vehicle
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                @forelse($vehicles as $index => $vehicle)
                                                    <label class="d-flex justify-content-between align-items-center border p-3 mb-3 bg-light bg-gradient" for="vehicleRadio{{ $vehicle->id }}">
                                                        <div class="me-2">
                                                            <h4 class="mb-1 fw-bold">{{ ucwords($vehicle->type) }}</h4>
                                                            <medium class="text-muted">Brand: {{ $vehicle->brand }}</medium><br>
                                                            <medium class="text-muted">Color: {{ $vehicle->color }}</medium><br>
                                                            <medium class="text-muted">Model: {{ $vehicle->model }}</medium><br>
                                                            <medium class="text-muted">Plate Number: {{ $vehicle->plate_number }}</medium><br>
                                                        </div>

                                                        <div class="d-flex align-items-center gap-2">
                                                            <input class="form-check-input" 
                                                                type="radio" 
                                                                name="vehicle_id" 
                                                                id="vehicleRadio{{ $vehicle->id }}" 
                                                                value="{{ $vehicle->id }}">
                                                        </div>
                                                    </label>
                                                @empty
                                                    <div class="container text-secondary text-center p-2">
                                                        No vehicles available.
                                                    </div>
                                                @endforelse
                                            </div>

                                            @if($vehicles->isNotEmpty())
                                                <div class="modal-footer">
                                                    <button class="btn btn-success" type="submit">
                                                        Start Delivery
                                                    </button>
                                                </div>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
        @empty
            <h1 class="text-center">No pending delivery.</h1>
        @endforelse
    
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modals = document.querySelectorAll('.modal');
            modals.forEach(function(modal) {
                modal.addEventListener('hidden.bs.modal', function() {
                    var forms = this.querySelectorAll('form');
                    forms.forEach(function(form) {
                        form.reset();
                    });
                });
            });
        });
    </script>
@endpush