@extends('layouts.admin.layout')

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
                    <h2 class="card-title mb-0 fw-bold">{{ $project->project_name }}</h2>
                </div>
            <div class="text-end">
                <span class="badge bg-primary mt-2 fs-5">{{ ucwords($project->status) }}</span>
            </div>
        </div>

        <div class="card-body">
            {{-- Project Overview --}}
            <h4 class="fw-bold text-primary">
                <i class="bi bi-box-seam"></i> Project Overview
            </h4>
            <p class="mb-5 text-muted">{{ $project->description ?? 'No description provided' }}</p>

            {{-- Location --}}
            <h4 class="fw-bold text-primary">
                <i class="bi bi-geo-alt"></i> Location
            </h4>
            <p class="mb-1">{{ ($project->house . ', ' . $project->zipcode) ?? 'N/A' }}</p>
            <p class="mb-5">{{ ($project->province . ', ' . $project->city . ', ' . $project->barangay) ?? 'N/A' }}</p>

            {{-- Project Owner --}}
            <h4 class="fw-bold text-primary">
                <i class="bi bi-person"></i> Project Owner
            </h4>
            <p class="mb-1"><strong>Name:</strong> {{ $project->owner->name ?? 'N/A' }}</p>
            <p class="mb-1"><strong>Phone:</strong> {{ $project->owner->contact_number ?? 'N/A' }}</p>
            <p class="mb-5"><strong>Email:</strong> {{ $project->owner->email ?? 'N/A' }}</p>

            {{-- Assigned --}}
            <h4 class="fw-bold text-primary">
                <i class="bi bi-check2-circle"></i> Assigned
            </h4>
            <p class="mb-1"><strong>Worker:</strong> {{ $project->worker->name ?? 'N/A' }}</p>
            <p class="mb-1"><strong>ID:</strong> {{ $project->worker->employeeCode() ?? 'N/A' }}</p>

            <hr class="mt-5">

            <div class="card-body">
                <!-- Tabs List -->
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-auto">
                        <ul class="nav nav-tabs flex-nowrap" id="resourceTabs" role="tablist">
                            @forelse($resources as $index => $resource)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link @if(session('active_tab') == $resource->id) active @endif"
                                        id="resource{{$index}}-tab" data-bs-toggle="tab" data-bs-target="#resource{{$index}}"
                                        type="button" role="tab">
                                        Resource {{$index + 1}}
                                    </button>
                                </li>
                            @empty
                                <li class="text-secondary">No resources.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="tab-content mt-3" id="resourceTabsContent">
                    @if($resources)
                        @foreach($resources as $index => $resource)
                            <!-- Editable Resource -->
                            <div class="tab-pane fade show @if(session('active_tab') == $resource->id) active @endif" id="resource{{$index}}" role="tabpanel">
                                <!-- Title and Status -->
                                <div class="col-12">
                                    <!-- Project status badges -->
                                    <span class="badge bg-primary mt-2 fs-5">{{ ucfirst($resource->status) }}</span>
                                </div>

                                <!-- Details -->
                                <div class="col-12 mt-4">
                                    <span class="text-primary"
                                        style="cursor:pointer;"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#resourceDetailsModal{{ $index }}">
                                        View Details
                                        <i class="bi bi-info-circle"></i>
                                    </span>
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

                                <!-- Created at -->
                                <div class="col-12 mt-4">
                                    <h5 class="fw-bold">Created at:</h5>
                                    <p>
                                        {{ $resource->created_at->format('Y-m-d') }}
                                    </p>
                                </div>

                                <!-- Schedule -->
                                <div class="mt-4">
                                    <h5 class="fw-bold">Date Needed:</h5>
                                    <p>
                                        {{ optional($resource->schedule)->format('Y-m-d') ?? 'N/A' }}
                                    </p>
                                </div>

                                <!-- Remarks -->
                                <div class="col-12 mt-4">
                                    <h5 class="fw-bold">Remarks:</h5>
                                    <p>
                                        {{ $resource->remark ?? 'N/A' }}
                                    </p>
                                </div>
                                
                                <hr>
                                
                                <!-- Others - Display Resources Table / Buttons  -->
                                <div class="card-body p-0">
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="pills-resources-tab{{$index}}" data-bs-toggle="pill" data-bs-target="#pills-resources{{$index}}" type="button" role="tab" aria-controls="pills-resources{{$index}}" aria-selected="true">
                                                Resources
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-history-tab{{$index}}" data-bs-toggle="pill" data-bs-target="#pills-history{{$index}}" type="button" role="tab" aria-controls="pills-history{{$index}}" aria-selected="false">
                                                History
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-resources{{$index}}" role="tabpanel" aria-labelledby="pills-resources-tab{{$index}}">
                                            <!-- Resources Table -->
                                            <div class="card shadow-sm mt-4" id="resourcesTable">
                                                <div
                                                    class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                                                    <h5 class="mb-0">Resources</h5>
                                                </div>
                                                    <!-- Display Table -->
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-striped align-middle text-center mb-0">
                                                        <thead class="table-dark text-white">
                                                            <tr>
                                                                <th class="col-1">No.</th>
                                                                <th class="col-2">Name</th>
                                                                <th class="col-4">Description</th>
                                                                <th class="col-1">Quantity</th>
                                                                <th class="col-1">Cost</th>
                                                                <th class="col-1">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($resource->items as $index2 => $item)
                                                                <tr>
                                                                    <td>{{ $index2 + 1 }}</td>
                                                                    <td class="text-start">
                                                                        @if($item->details->category === 'material')
                                                                            <i class="bi bi-box"></i>
                                                                        @else
                                                                            <i class="bi bi-wrench"></i>
                                                                        @endif
                                                                        {{ $item->details->name }}
                                                                    </td>
                                                                    <td class="text-start">{{ $item->details->description }}</td>
                                                                    <td>
                                                                        {{ $item->quantity . ' ' . $item->details->measure}}
                                                                    </td>
                                                                    <td class="text-end pe-3">
                                                                        ₱{{ number_format($item->details->cost * $item->quantity, 2) }}</td>
                                                                    <td>{{ $item->status }}</td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="5" class="text-center text-muted">No resources added yet</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                        @if($resource->items->isNotEmpty())
                                                            <tfoot class="table-light fw-bold">
                                                                <tr>
                                                                    <td colspan="3"></td>
                                                                    <td>Total:</td>
                                                                    <td class="text-end pe-3">₱{{ number_format($resource->items->sum(fn($item) => $item->details->cost * $item->quantity), 2) }}</td>
                                                                    <td></td>
                                                                </tr>
                                                            </tfoot>
                                                        @endif
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Status History -->
                                        <div class="tab-pane fade" id="pills-history{{$index}}" role="tabpanel" aria-labelledby="pills-history-tab{{$index}}">
                                            <div class="card-body">
                                                <ul class="list-group list-group-flush">
                                                    @forelse($resource->statusHistory as $status)
                                                        <li class="list-group-item d-flex align-items-start">
                                                            <div class="me-3 fs-5">
                                                                <i class="bi bi-check-circle-fill text-success"></i>
                                                            </div>

                                                            <div class="flex-grow-1">
                                                                <div class="fw-bold text-success">{{ $status->status }}</div>
                                                                <small>{{ $status->description ?: 'No description.' }}</small>
                                                            </div>

                                                            <div class="text-end ms-3">
                                                                <small class="text-muted d-block">{{ $status->created_at->format('h:i A') }}</small>
                                                                <small class="text-muted">{{ $status->created_at->format('F j, Y') }}</small>
                                                            </div>
                                                        </li>
                                                    @empty
                                                        No update.
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 p-3">
                                        <!-- Back Button -->
                                        <a href="{{ route('admin.projects') }}"
                                            class="btn btn-secondary w-100 w-sm-auto">Back</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection