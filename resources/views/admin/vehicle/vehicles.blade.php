@extends('layouts.admin.layout')

@section('title', 'Vehicles')

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
    
    <div class="card shadow-sm fs-5">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="bi bi-truck-front"></i> Vehicle List</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVehicleModal">
                <i class="bi bi-plus"></i> Add Vehicle
            </button>

            <!-- Modal -->
            <div class="modal fade" id="addVehicleModal" tabindex="-1" aria-labelledby="addVehicleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content shadow-lg">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="addVehicleModalLabel"><i class="bi bi-folder-plus"></i> Add Vehicle</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <form action="{{ route('admin.vehicle.add') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <!-- Type -->
                                <div class="mb-3">
                                    <label for="type" class="form-label fw-bold">Type</label>
                                    <select class="form-select" name="type" id="type">
                                        <option value="truck">Truck</option>
                                        <option value="car">Car</option>
                                        <option value="motorcycle">Motorcycle</option>
                                        <option value="e-bike">E-bike</option>
                                        <option value="others">Others</option>
                                    </select>
                                </div>

                                <!-- Brand -->
                                <div class="mb-3">
                                    <label for="brand" class="form-label fw-bold">Brand</label>
                                    <input type="text" class="form-control" id="brand" name="brand" required>
                                </div>

                                <!-- Color -->
                                <div class="mb-3">
                                    <label for="color" class="form-label fw-bold">Color</label>
                                    <input type="text" class="form-control" id="color" name="color" required>
                                </div>

                                <!-- Model -->
                                <div class="mb-3">
                                    <label for="model" class="form-label fw-bold">Model</label>
                                    <input type="text" class="form-control" id="model" name="model" required>
                                </div>

                                <!-- Plate Number -->
                                <div class="mb-3">
                                    <label for="plate_number" class="form-label fw-bold">Plate Number</label>
                                    <input type="text" class="form-control" id="plate_number" name="plate_number" required>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                                <button onclick="this.disabled=true;this.form.submit();" type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Save Vehicle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="list-group list-group-flush">
            @forelse($vehicles as $index => $vehicle)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="me-2">
                        <h4 class="mb-1 fw-bold">{{ ucwords($vehicle->type) }}</h4>
                        <medium class="text-muted">Brand: {{ ucwords($vehicle->brand) }}</medium><br>
                        <medium class="text-muted">Color: {{ ucwords($vehicle->color) }}</medium><br>
                        <medium class="text-muted">Model: {{ ucwords($vehicle->model) }}</medium><br>
                        <medium class="text-muted">Plate Number: {{ ucwords($vehicle->plate_number) }}</medium><br>
                        <medium class="text-muted">Created: {{ $vehicle->created_at->format('F m, Y') }}</medium>
                    </div>
                    
                    <div class="d-flex align-items-center gap-2">
                        <x-status-badge status="{{ $vehicle->status }}" class="fs-5" />
                        @if($vehicle->status !== 'occupied')
                            <a href="{{ route('admin.vehicle.edit.view', $vehicle->id) }}" class="btn btn-light btn-lg border">
                                <i class="bi bi-gear"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
            <div class="container text-secondary text-center p-2">
                No projects.
            </div>
            @endforelse
        </div>
    </div>
@endsection