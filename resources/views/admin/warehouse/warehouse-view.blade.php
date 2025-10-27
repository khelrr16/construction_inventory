@extends('layouts.admin.layout')

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
        <div class="card shadow-sm mb-4">
            {{-- Header --}}
            <div class="card-header d-flex justify-content-between align-items-start">
                <h2 class="card-title mb-0 fw-bold">
                    <a href="{{ route('admin.warehouses') }}"
                        class="text-decoration-none">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    {{ $warehouse->name }}
                </h2>
            </div>

            <div class="card-body">
                {{-- Location --}}
                <div class="mb-4">
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
                
                <div class="mb-4">
                    {{-- Inventory Clerks --}}
                    <h4 class="fw-bold text-primary">
                        <i class="bi bi-person"></i> Inventory Clerks
                    </h4>
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

                {{-- <livewire:warehouse-items :warehouseId="$warehouse->id"/> --}}
                @include('parts.tables.item-table-1')

                {{-- <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle text-center mb-0">
                        <thead class="table-dark text-white">
                            <tr>
                                <th class="col-1">No. 1</th>
                                <th class="col-1">Category</th>
                                <th class="col-2">Name</th>
                                <th class="col-4">Description</th>
                                <th class="col-1">Stocks</th>
                                <th class="col-1">Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($warehouse->items as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ ucwords($item->category) }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->stocks.' '.$item->measure }}</td>
                                    <td class="text-end pe-3">₱{{ number_format($item->cost, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No items yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div> --}}
            </div>
        </div>
    </div>
@endsection