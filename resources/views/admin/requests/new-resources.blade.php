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
                        <p class="mb-1"><strong>ID:</strong> {{ 'WRK-'.str_pad($resource->project->worker->id,3,'0',STR_PAD_LEFT) ?? 'N/A' }}</p>

                        <hr class="mt-5">

                        <div class="card-body p-0">
                            <!-- Resources Table -->
                            <div class="card shadow-sm mt-4" id="resourcesTable">
                                <div
                                    class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
                                    <h5 class="mb-0">Resource {{ $resource->id }}</h5>
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
                                            @forelse($resource->items as $item_index => $item)
                                                <tr>
                                                    <td>{{ $item_index + 1 }}</td>
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
                                {{-- <!-- Back Button -->
                                <a href="{{ route('admin.requests.resources.update', ['resource_id' => $resource->id, 'value' => '0']) }}"
                                    class="btn btn-danger w-100 w-sm-auto">Deny</a>
                                    
                                <a href="{{ route('admin.requests.resources.update', ['resource_id' => $resource->id, 'value' => '1']) }}"
                                    class="btn btn-success w-100 w-sm-auto">Accept</a> --}}
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