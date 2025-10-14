@extends('layouts.admin.layout')

@section('title', 'Title')

@section('content')
        <div class="container mt-5">
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

            <!-- Project Info Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h3 class="card-title mb-3">
                        <strong>Project Name: <span class="text-primary">{{ $project->project_name }}</span></strong>
                    </h3>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <strong>Status:</strong>
                            <!-- Project status badges -->
                            <span
                                @if($project->status === 'processing') class="badge bg-warning"
                                @elseif($project->status === 'completed') class="badge bg-success"
                                @elseif($project->status === 'cancelled') class="badge bg-warning"
                                @else class="badge bg-secondary" @endif>{{ ucfirst($project->status) }}</span>
                        </div>

                        <form id="projectForm" action="" method="POST">
                            @csrf @method('PUT')
                            <div class="col-12 mt-3">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3"
                                    placeholder="Enter project description">{{ $project->description }}</textarea>
                            </div>

                            <div class="mt-3">
                                <label for="worker" class="form-label fw-bold">Assign</label>
                                <select name="worker_id" id="worker" class="form-control" required>
                                    <option selected disabled>--Site Worker--</option>
                                    @if($workers)
                                        @foreach($workers as $worker)
                                            <option 
                                                @if($project->worker_id == $worker->id) selected @endif 
                                                value="{{ $worker->id }}">
                                                {{$worker->employeeCode().' | '.$worker->email}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="mt-3">
                                <label class="form-label fw-bold">Address</label>
                            </div>
                            <div class="ps-4">
                                <div class="col-12 mt-3">
                                    <label class="form-label fw-bold">House Number & Street</label>
                                    <input type="text" name="house" class="form-control" value="{{  $project->house }}">
                                </div>
                                <div class="col-12 mt-3">
                                    <label class="form-label fw-bold">Barangay</label>
                                    <input type="text" name="barangay" class="form-control" value="{{  $project->barangay }}">
                                </div>
                                <div class="col-12 mt-3">
                                    <label class="form-label fw-bold">City</label>
                                    <input type="text" name="city" class="form-control" value="{{  $project->city }}">
                                </div>
                                <div class="col-12 mt-3">
                                    <label class="form-label fw-bold">Province</label>
                                    <input type="text" name="province" class="form-control" value="{{  $project->province }}">
                                </div>
                                <div class="col-12 mt-3">
                                    <label class="form-label fw-bold">ZIP Code</label>
                                    <input type="number" name="zipcode" class="form-control" value="{{  $project->zipcode }}">
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 p-3">
                                <!-- Back Button -->
                                <a href="{{ route('admin.projects') }}" class="btn btn-secondary w-100 w-sm-auto">Back</a>
                                <!-- Save Button -->
                                <button type="submit" id="btnSave" class="btn btn-primary w-100 w-sm-auto"
                                    formaction="{{ route('admin.project.update',['project_id' => $project->id, 'submit' => 'false',]) }}">
                                    Save
                                </button>
                                <!-- Request Button -->
                                <button type="submit" id="btnRequest" class="btn btn-success w-100 w-sm-auto"
                                    formaction="{{ route('admin.project.update', ['project_id' => $project->id, 'submit' => 'true']) }}">
                                    Request
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection