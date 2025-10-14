@extends('layouts.others.layout')

@section('title', 'Title')

@section('content')
    <div class="container mt-5 fs-5">
        <!-- Alert -->
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
        @elseif (session('error'))
        <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1080;">
            <div id="liveToastError" class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        @endif

        <div class="card shadow-sm mb-4">
            {{-- Header --}}
            <div class="card-header d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="card-title mb-0 fw-bold">
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

                                <!-- Project Details Modal -->
                                <div class="modal-body">
                                    {{-- Project Overview --}}
                                    <h4 class="fw-bold text-primary">
                                        <i class="bi bi-box-seam"></i> Project Overview
                                    </h4>
                                    <p class="mb-5 text-muted">{{ $resource->project->description ?? 'No description provided' }}</p>

                                    {{-- Location --}}
                                    <h4 class="fw-bold text-primary">
                                        <i class="bi bi-geo-alt"></i> Location
                                    </h4>
                                    <p class="mb-1">{{
                                        ($resource->project->house.', '.$resource->project->zipcode)
                                        ?? 'N/A' }}
                                    </p>
                                    <p class="mb-5">{{ 
                                        ($resource->project->province.', '.$resource->project->city.', '.$resource->project->barangay) 
                                        ?? 'N/A' }}
                                    </p>

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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <!-- Project status badges -->
                    <span class="badge bg-secondary fs-5">{{ ucfirst($resource->status) }}</span>
                </div>
            </div>

            <div class="card-body">
                <div class="tab-pane fade show @if(session('active_tab') == $resource->id) active @endif" id="resource" role="tabpanel">
                    <form action="{{ route('worker.resource_item.add.complete',  $resource->id) }}"
                        id="projectForm" method="POST">
                        @csrf
                        
                        <!-- Display Table -->
                        <livewire:items-table :resource_id="$resource->id"/>

                        <!-- Buttons -->
                        <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 p-3">
                            <!-- Back Button -->
                            <a href="{{ route('worker.resource.edit', $resource->id) }}"
                                class="btn btn-secondary w-100 w-sm-auto">Back</a>
                            <!-- Save Button -->
                            <button
                                type="submit" id="btnSave" class="btn btn-primary w-100 w-sm-auto">
                                Add Items
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection