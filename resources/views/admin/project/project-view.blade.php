@extends('layouts.admin.layout')

@section('title', $project->project_name)

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

    <div class="container fs-5">
        <div class="card shadow-sm mb-4">
        {{-- Header --}}
        <div class="card-header d-flex justify-content-between">
            <h2 class="card-title mb-0 fw-bold">
                <a href="{{ route('admin.projects') }}"
                    class="text-decoration-none">
                    <i class="bi bi-arrow-left"></i>
                </a>
                {{ $project->project_name }}
            </h2>
            
            <div class="text-end">
                <x-status-badge status="{{ $project->status }}" class="fs-5" />
            </div>
        </div>

        <div class="card-body">
            @include('parts.details.project-details')

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
                                        Resource {{ $index+1 }}
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
                    @forelse($resources as $index => $resource)
                        <!-- Editable Resource -->
                        <div class="tab-pane fade show @if(session('active_tab') == $resource->id) active @endif" id="resource{{$index}}" role="tabpanel">
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
                                <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link border border-secondary active" id="pills-resources-tab{{$index}}" data-bs-toggle="pill" data-bs-target="#pills-resources{{$index}}" type="button" role="tab" aria-controls="pills-resources{{$index}}" aria-selected="true">
                                            Resources
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link border border-secondary" id="pills-history-tab{{$index}}" data-bs-toggle="pill" data-bs-target="#pills-history{{$index}}" type="button" role="tab" aria-controls="pills-history{{$index}}" aria-selected="false">
                                            History
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-resources{{$index}}" role="tabpanel" aria-labelledby="pills-resources-tab{{$index}}">
                                        <!-- Resources Table -->
                                        <div class="card shadow-sm mt-4" id="resourcesTable">
                                            <div
                                                class="card-header d-flex justify-content-between align-items-center bg-primary">
                                                <h5 class="mb-0 text-white"
                                                    style="cursor:pointer;"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#resourceDetailsModal{{ $index }}">
                                                    Resource <i class="bi bi-info-circle"></i>
                                                </h5>
                                                
                                                {{-- @if($resource->status == 'received') --}}
                                                    <a href="{{ route('receipts.resource-items', $resource->id) }}" target="_blank" class="btn btn-primary">
                                                        📄 Print Receipt
                                                    </a>
                                                {{-- @endif --}}
                                                
                                                <!-- Details Modal -->
                                                <div class="modal fade" id="resourceDetailsModal{{ $index }}" tabindex="-1" aria-labelledby="resourceDetailsModalLabel{{ $index }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="resourceDetailsModalLabel{{ $index }}">
                                                                    Resource Details
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
                                            
                                            <!-- Display Table -->
                                            @include('parts.tables.table-1')
                                        </div>
                                    </div>

                                    <!-- Status History -->
                                    <div class="tab-pane fade" id="pills-history{{$index}}" role="tabpanel" aria-labelledby="pills-history-tab{{$index}}">
                                        <div class="card-body">
                                            @include('parts.details.status-history')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection