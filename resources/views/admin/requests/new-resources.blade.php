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
                        @php $project = $resource->project; @endphp
                        @include('parts.details.project-details')

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

                            <!-- Buttons -->
                            <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 p-3">

                                <!-- Button trigger modal -->
                                <button type="button" 
                                        class="btn btn-primary w-100 w-sm-auto" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#respondModal{{ $index }}">
                                        
                                        Respond
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="respondModal{{ $index }}" tabindex="-1" aria-labelledby="respondModalLabel{{ $index }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <!-- Header -->
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="respondModalLabel{{ $index }}">{{$resource->project->project_name}}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            
                                            <!-- Body -->
                                            <form action="" method="POST">
                                                @csrf @method('PUT')
                                                <div class="modal-body">
                                                    <!-- Remarks -->
                                                    <div class="col-12">
                                                        <label for="remark" class="form-label fw-bold">Remarks</label>
                                                        <textarea name="remark" id="remark" class="form-control" rows="3"
                                                            placeholder="">{{ $resource->remark ?? ''}}</textarea>
                                                    </div>
                                                </div>

                                                <!-- Footer -->
                                                <div class="modal-footer">
                                                    <button type="submit" 
                                                        formaction="{{route('admin.requests.resources.update',['resource_id' => $resource->id, 'value' => '0'])}}"
                                                        class="btn btn-secondary" data-bs-dismiss="modal">Decline</button>
                                                    
                                                    <button type="submit"
                                                        formaction="{{route('admin.requests.resources.update',['resource_id' => $resource->id, 'value' => '1'])}}"
                                                        class="btn btn-primary">Approve</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
        <h1 class="text-center">No pending request.</h1>
        @endforelse
    </div>
@endsection