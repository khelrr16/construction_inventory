@extends('layouts.worker.layout')

@section('title', $resource->project->project_name. ' Add Item')

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
                <div>
                    <h2 class="card-title mb-0 fw-bold">
                        <a class="text-decoration-none"
                            href="{{ route('worker.resource.edit', $resource->id) }}">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        
                        {{ $resource->project->project_name }}

                        <!-- Button trigger modal -->
                        <i class="bi bi-info-circle text-primary"
                            style="cursor:pointer;"
                            data-bs-toggle="modal" 
                            data-bs-target="#resourceDetailsModal">
                        </i>
                    </h2>
                    
                    <!-- Details Modal -->
                    <div class="modal fade" id="resourceDetailsModal" tabindex="-1" aria-labelledby="resourceDetailsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="resourceDetailsModal">
                                        Project Details
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                @php $project = $resource->project @endphp
                                @include('parts.details.project-details')
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <!-- Project status badges -->
                    <span class="badge bg-primary fs-5">{{ ucfirst($resource->project->status) }}</span>
                </div>
            </div>

            <div class="card-body">
                <!-- Display Table -->
                <livewire:items-table :resource_id="$resource->id"/>
            </div>
        </div>
    </div>
@endsection