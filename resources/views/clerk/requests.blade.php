@extends('layouts.clerk.layout')

@section('title', 'Requests For Packing')

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
        <h3>Requested Resources For Packing</h3>
        <hr>
        @forelse($resources as $index => $resource)
            <div class="card shadow-sm mb-4">
                {{-- Header --}}
                <div class="card-header d-flex justify-content-between align-items-start"
                    data-bs-toggle="collapse"
                    data-bs-target="#resource-{{ $index}}" 
                    aria-expanded="false" 
                    aria-controls="resource-{{ $index}}" 
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
                        {{-- Project Overview --}}
                        <h4 class="fw-bold text-primary">
                            <i class="bi bi-box-seam"></i> Project Overview
                        </h4>
                        <p class="mb-5 text-muted">{{ $resource->project->description ?? 'No description provided' }}</p>

                        {{-- Location --}}
                        <h4 class="fw-bold text-primary">
                            <i class="bi bi-geo-alt"></i> Location
                        </h4>
                        <p class="mb-1">{{ ($resource->project->house . ', ' . $resource->project->zipcode) ?? 'N/A' }}</p>
                        <p class="mb-5">{{ ($resource->project->province . ', ' . $resource->project->city . ', ' . $resource->project->barangay) ?? 'N/A' }}</p>

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

                        <hr class="mt-5">

                        <div class="card-body p-0">
                            <!-- Resources Table -->
                            <div class="card shadow-sm mt-4">
                                <div class="card-header d-flex justify-content-between align-items-center bg-primary">
                                    <h5 class="mb-0 text-white"
                                        style="cursor:pointer;"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#resourceDetailsModal{{ $index }}">
                                        Resource <i class="bi bi-info-circle"></i>
                                    </h5>

                                    <!-- Details Modal -->
                                    <div class="modal fade" 
                                        id="resourceDetailsModal{{ $index }}" 
                                        tabindex="-1"
                                        aria-labelledby="resourceDetailsModalLabel{{ $index }}" 
                                        aria-hidden="true">
                                        
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="resourceDetailsModal{{ $index }}">
                                                        View Details
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

                                <!-- Table -->
                                @include('parts.tables.table-1')
                            </div>

                            <!-- Button trigger modal -->
                            <form action="{{route('clerk.resource.prepare', $resource->id)}}" method="POST">
                                @csrf @method('PUT')
                                
                                <button type="submit" class="btn btn-primary w-100 w-sm-auto">
                                    Start Preparing
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            
        @empty
            <h1 class="text-center">No pending request.</h1>
        @endforelse
    </div>
@endsection