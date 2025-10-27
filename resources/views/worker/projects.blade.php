@extends('layouts.worker.layout')

@section('title', 'Projects')

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

    <div class="container py-4 fs-5">
        <!-- Projects Section -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-folder2-open"></i> Assigned Projects</h4>
            </div>
            <div class="list-group list-group-flush">
                @forelse($projects as $index => $project)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="me-2">
                            <h4 class="mb-1 fw-bold">{{ $project->project_name }}</h4>
                            <medium class="text-muted">{{ $project->description }}</medium><br>
                            <medium class="text-muted">Resources: {{ count($project->resources) }}</medium><br>
                            <medium class="text-muted">Created: {{ $project->created_at->format('F j, Y') }}</medium>
                        </div>
                        
                        <div class="d-flex align-items-center gap-2">
                            <!-- Project status badges -->
                            <x-status-badge status="{{ $project->status }}" class="fs-5" />

                            <a href="{{ route('worker.project.view', $project->id) }}" class="btn btn-light btn-lg border">
                                <i class="bi bi-gear"></i>
                            </a>
                        </div>
                    </div>
                @empty
                <div class="container text-secondary text-center p-2">
                    No projects.
                </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection