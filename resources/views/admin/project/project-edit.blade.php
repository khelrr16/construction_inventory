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
    
    <div class="container mt-5 fs-5">
        <!-- Project Info Card -->
        <div class="card shadow-sm mb-4">
            <form action="{{ route('admin.project.update',$project->id) }}"
                method="POST">
                @csrf @method('PUT')

                <div class="card-header d-flex justify-content-between align-items-start">
                    <h2 class="card-title mb-0 fw-bold">
                        <a href="{{ route('admin.projects') }}"
                            class="text-decoration-none">
                            <i class="bi bi-arrow-left"></i>
                        </a>
                        {{ $project->project_name }}
                    </h2>
                    
                    <div class="text-end">
                        <select class="form-select fs-5"
                            name="status">
                            
                            <option @if($project->status == 'draft') selected @endif
                                class="fw-bold text-muted"
                                value="draft">
                                Draft
                            </option>

                            <option @if($project->status == 'active') selected @endif
                                class="fw-bold text-primary"
                                value="active">
                                Active
                            </option>

                            <option @if($project->status == 'postponed') selected @endif
                                class="fw-bold text-warning"
                                value="postponed">
                                Postponed
                            </option>

                            <option @if($project->status == 'discontinued') selected @endif
                                class="fw-bold text-danger"
                                value="discontinued">
                                Discontinued
                            </option>

                            <option @if($project->status == 'completed') selected @endif
                                class="fw-bold text-success"
                                value="completed">
                                Completed
                            </option>
                            
                        </select>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mt-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3"
                                placeholder="Enter project description">{{ $project->description }}</textarea>
                        </div>

                        <div class="mt-3">
                            <label for="worker" class="form-label fw-bold">Assign</label>
                            <select name="worker_id" id="worker" class="form-control text-mute" required>
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
                            <!-- Save Button -->
                            <button type="submit" id="btnSave" class="btn btn-primary w-100 w-sm-auto">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection