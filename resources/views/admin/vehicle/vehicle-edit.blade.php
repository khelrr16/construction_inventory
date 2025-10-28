@extends('layouts.admin.layout')

@section('title', 'Vehicle Edit')

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
    
    <div class="card shadow-sm">
        <form action="{{ route('admin.vehicle.edit.complete', $vehicle->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold">
                    <a href="{{ route('admin.vehicles') }}"
                        class="text-decoration-none">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    Vehicle Edit
                </h4>

                <div class="text-end">
                    <select class="form-select fs-5" name="status">
                        <option @if($vehicle->status == 'inactive') selected @endif
                            value="inactive">
                            Inactive
                        </option>
                        
                        <option @if($vehicle->status == 'active') selected @endif
                            value="active">
                            Active
                        </option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="modal-body">
                    <!-- Type -->
                    <div class="mb-3">
                        <label for="type" class="form-label fw-bold">Type</label>
                        <select class="form-select" name="type" id="type">
                            <option @if($vehicle->type == 'truck') selected @endif
                                value="truck">Truck</option>
                            <option @if($vehicle->type == 'car') selected @endif
                                value="car">Car</option>
                            <option @if($vehicle->type == 'motorcycle') selected @endif
                                value="motorcycle">Motorcycle</option>
                            <option @if($vehicle->type == 'e-bike') selected @endif
                                value="e-bike">E-bike</option>
                            <option @if($vehicle->type == 'others') selected @endif
                                value="others">Others</option>
                        </select>
                    </div>

                    <!-- Brand -->
                    <div class="mb-3">
                        <label for="brand" class="form-label fw-bold">Brand</label>
                        <input type="text" value="{{ $vehicle->brand }}"
                            class="form-control" id="brand" name="brand" required>
                    </div>

                    <!-- Color -->
                    <div class="mb-3">
                        <label for="color" class="form-label fw-bold">Color</label>
                        <input type="text" value="{{ $vehicle->color }}"
                            class="form-control" id="color" name="color" required>
                    </div>

                    <!-- Model -->
                    <div class="mb-3">
                        <label for="model" class="form-label fw-bold">Model</label>
                        <input type="text" value="{{ $vehicle->model }}"
                            class="form-control" id="model" name="model" required>
                    </div>

                    <!-- Plate Number -->
                    <div class="mb-3">
                        <label for="plate_number" class="form-label fw-bold">Plate Number</label>
                        <input type="text" value="{{ $vehicle->plate_number }}"
                            class="form-control" id="plate_number" name="plate_number" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button onclick="this.disabled=true;this.form.submit();" 
                        type="submit" 
                        class="btn btn-success">
                        <i class="bi bi-check-circle"></i> Save Vehicle
                    </button>
                </div>
                
            </div>
        </form>
    </div>
@endsection