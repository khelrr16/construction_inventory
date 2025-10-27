@extends('layouts.admin.layout')

@section('title', 'Warehouses')

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

    <div class="container py-4 fs-5">
        <!-- Projects Section -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-folder2-open"></i> Warehouses</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                    <i class="bi bi-plus"></i> Add Warehouse
                </button>
            </div>
            
            <div class="list-group list-group-flush">
                @forelse($warehouses as $index => $warehouse)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="me-2">
                            <h4 class="mb-1 fw-bold">{{ $warehouse->name }}</h4>
                            <p class="mb-1">
                                <i class="bi bi-geo-alt"></i>
                                {{ ($warehouse->house . ', ' . $warehouse->zipcode) ?? 'N/A' }}
                            </p>
                            <p class="mb-1">
                                {{ ($warehouse->barangay . ', ' . $warehouse->city . ', ' . $warehouse->province) ?? 'N/A' }}
                            </p>
                            <p class="mb-1">
                                {{ count($warehouse->items) }} items registered
                            </p>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary">{{ ucwords($warehouse->status) }}</span>
                            <!-- Project status badges -->
                            <a href="{{ route('admin.warehouse.edit', $warehouse->id) }}" class="btn btn-light btn-lg border">
                                <i class="bi bi-gear"></i>
                            </a>

                            <a href="{{ route('admin.warehouse.view', $warehouse->id) }}" class="btn btn-light btn-lg border">
                                <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </div>
                    </div>
                @empty
                <div class="container text-secondary text-center p-2">
                    No warehouse.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="addProjectModalLabel"><i class="bi bi-folder-plus"></i> Add Warehouse</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <form action="{{ route('admin.warehouse.new') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <!-- Project Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Warehouse Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <!-- Project Description -->
                            <div class="mb-3">
                                <h5 class="fw-bold">Address</h5>

                                <div class="ps-3">
                                    <label for="house" class="form-label fw-bold">Area Details</label>
                                    <input class="form-control" type="text" id="house" name="house" required>

                                    <label for="barangay" class="form-label fw-bold">Barangay</label>
                                    <input class="form-control" type="text" id="barangay" name="barangay" required>

                                    <label for="city" class="form-label fw-bold">City</label>
                                    <input class="form-control" type="text" id="city" name="city" required>

                                    <label for="province" class="form-label fw-bold">Province</label>
                                    <input class="form-control" type="text" id="province" name="province" required>

                                    <label for="zipcode" class="form-label fw-bold">Zipcode</label>
                                    <input class="form-control" type="number" id="zipcode" name="zipcode" required>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Save Warehouse</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection