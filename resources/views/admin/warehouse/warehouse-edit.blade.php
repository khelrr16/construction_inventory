@extends('layouts.admin.layout')

@section('title', $warehouse->name)

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
            <form action="{{ route('admin.warehouse.update', $warehouse->id) }}" method="POST">
                @csrf @method('PUT')
                {{-- Header --}}
                <div class="card-header d-flex justify-content-between align-items-start">
                    <h2 class="card-title mb-0 fw-bold">
                        <a href="{{ route('admin.warehouses') }}"
                            class="text-decoration-none">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        {{ $warehouse->name }}
                    </h2>
                    <div class="text-end">
                        <select class="form-select fs-5"
                            name="status">

                            <option @if($warehouse->status == 'inactive') selected @endif
                                class="fw-bold text-muted"
                                value="inactive">
                                Inactive
                            </option>

                            <option @if($warehouse->status == 'active') selected @endif
                                class="fw-bold text-primary"
                                value="active">
                                Active
                            </option>                        
                        </select>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="mb-4">
                        {{-- Inventory Clerks --}}
                        <h4 class="fw-bold text-primary">
                            <i class="bi bi-person"></i> Inventory Clerks
                        </h4>

                        <div class="ps-3">
                            @forelse($warehouse->users as $user)
                                <p class="mb-1">
                                    <b>{{ $user->name }}</b>
                                    <br>
                                    {{ $user->employeeCode() }}
                                </p>
                            @empty
                                <p class="mb-1 text-secondary">
                                    <i>No user assigned.</i>
                                </p>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- Project Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Warehouse Name</label>
                        <input value="{{ $warehouse->name }}"
                            type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <!-- Project Description -->
                    <div class="mb-3">
                        <h5 class="fw-bold">Address</h5>

                        <div class="ps-3">
                            <label for="house" class="form-label fw-bold">Area Details</label>
                            <input value="{{ $warehouse->house }}"
                                class="form-control" type="text" id="house" name="house" required>

                            <label for="barangay" class="form-label fw-bold">Barangay</label>
                            <input value="{{ $warehouse->barangay }}"
                                class="form-control" type="text" id="barangay" name="barangay" required>

                            <label for="city" class="form-label fw-bold">City</label>
                            <input value="{{ $warehouse->city }}"
                                class="form-control" type="text" id="city" name="city" required>

                            <label for="province" class="form-label fw-bold">Province</label>
                            <input value="{{ $warehouse->province }}"
                                class="form-control" type="text" id="province" name="province" required>

                            <label for="zipcode" class="form-label fw-bold">Zipcode</label>
                            <input value="{{ $warehouse->zipcode }}"
                                class="form-control" type="number" id="zipcode" name="zipcode" required>
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex flex-column flex-sm-row gap-2 p-3">
                    <button type="button" class="btn btn-light border w-100">Cancel</button>
                    <button type="submit" class="btn btn-success w-100"><i class="bi bi-check-circle"></i> Save Warehouse</button>
                </div>
            </form>
        </div>
    </div>
@endsection