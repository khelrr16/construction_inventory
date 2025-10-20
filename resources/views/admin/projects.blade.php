@extends('layouts.admin.layout')

@section('title', 'Projects')

@section('content')
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
    
    <!-- Projects Section -->
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="bi bi-folder2-open"></i> Project List (Admin)</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                <i class="bi bi-plus"></i> Add Project
            </button>
        </div>
        <div class="list-group list-group-flush">
            @forelse($projects as $index => $project)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="me-2">
                        <h4 class="mb-1 fw-bold">{{ $project->project_name }}</h4>
                        <medium class="text-muted">{{ $project->description }}</medium><br>
                        <medium class="text-muted">Created: {{ $project->created_at->format('Y-m-d') }}</medium>
                    </div>
                    
                    <div class="d-flex align-items-center gap-2">
                        <!-- Project status badges -->
                        <span class="badge
                        @switch($project->status)
                            @case('processing')
                                bg-warning @break
                            @case('completed')
                                bg-success @break
                            @case('cancelled') @case('incomplete')
                                bg-danger @break
                            @default
                                bg-secondary @break
                        @endswitch fs-5">{{ ucfirst($project->status) }}</span>

                        @if($project->status === 'draft')
                            <a href="{{ route('admin.project.edit', $project->id) }}" class="btn btn-light btn-lg border">
                        @else
                            <a href="{{ route('admin.project.view', $project->id) }}" class="btn btn-light btn-lg border">
                        @endif
                        <i class="bi bi-gear"></i></a>
                        
                    </div>
                </div>
            @empty
            <div class="container text-secondary text-center p-2">
                No projects.
            </div>
            @endforelse
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addProjectModalLabel"><i class="bi bi-folder-plus"></i> Add Project</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <form action="{{ route('admin.project.new') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Project Name -->
                        <div class="mb-3">
                            <label for="project_name" class="form-label fw-bold">Project Name</label>
                            <input type="text" class="form-control" id="project_name" name="project_name"
                                placeholder="Enter project name" required>
                        </div>

                        <!-- Project Description -->
                        <div class="mb-3">
                            <label for="project_description" class="form-label fw-bold">Project Description</label>
                            <textarea class="form-control" id="project_description" name="description" rows="3"
                                placeholder="Enter project description" required></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Save Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide toast messages after 5 seconds
    const toasts = document.querySelectorAll('.toast');
    toasts.forEach(toast => {
        setTimeout(() => {
            const bsToast = new bootstrap.Toast(toast);
            bsToast.hide();
        }, 5000);
    });
});
</script>
@endpush