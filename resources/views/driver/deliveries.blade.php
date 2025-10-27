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
                        @php $project= $resource->project @endphp
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
                                                    <!-- Created by -->
                                                    <div class="mb-3">
                                                        <h5 class="fw-bold">Created by:</h5>
                                                        {{ $resource->creator->name }} 
                                                        <br> {{ $resource->creator->employeeCode() }}
                                                    </div>

                                                    <!-- Warehouse -->
                                                    <div class="mb-3">
                                                        <h5 class="fw-bold">Warehouse:</h5>
                                                        @if($resource->warehouse)
                                                            {{ $resource->warehouse->name }} 
                                                            <br> {{ $resource->warehouse->house
                                                            .', '.$resource->warehouse->zipcode }}
                                                            <br> {{ $resource->warehouse->barangay
                                                            .', '.$resource->warehouse->city
                                                            .', '.$resource->warehouse->province }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </div>

                                                    <!-- Approved By: -->
                                                    <div class="mb-3">
                                                        <h5 class="fw-bold">Approved By:</h5>
                                                        @if($resource->approver)
                                                            {{ $resource->approver->name }} 
                                                            <br> {{ $resource->approver->employeeCode() }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </div>

                                                    <!-- Prepared By: -->
                                                    <div class="mb-3">
                                                        <h5 class="fw-bold">Prepared By:</h5>
                                                        @if($resource->preparer)
                                                            {{ $resource->preparer->name }} 
                                                            <br> {{ $resource->preparer->employeeCode() }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </div>

                                                    <!-- Driver: -->
                                                    <div class="mb-3">
                                                        <h5 class="fw-bold">Delivered By:</h5>
                                                        @if($resource->driver)
                                                            {{ $resource->driver->name }} 
                                                            <br> {{ $resource->driver->employeeCode() }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Display Table -->
                                @include('parts.tables.table-1')
                            </div>

                            <!-- Complete Button -->
                            <form action="{{ route('driver.delivery.complete',  $resource->id)}}"
                                method="POST">
                                @csrf @method('PUT')

                                <button class="btn btn-success w-100 w-sm-auto" type="submit">
                                    Complete Delivery
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <h1 class="text-center">No current delivery.</h1>
        @endforelse
    
    </div>
@endsection