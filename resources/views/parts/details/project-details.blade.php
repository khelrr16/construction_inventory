{{-- Project Overview --}}
<h4 class="fw-bold text-primary">
    <i class="bi bi-box-seam"></i> Project Overview
</h4>
<p class="mb-5 text-muted">{{ $project->description ?? 'No description provided' }}</p>

{{-- Location --}}
@if($project->province && $project->city && $project->barangay)
    <h4 class="fw-bold text-primary">
        <i class="bi bi-geo-alt"></i> Location
    </h4>
    <p class="mb-1">{{ ($project->house . ', ' . $project->zipcode) ?? 'N/A' }}</p>
    <p class="mb-5">{{ ($project->province . ', ' . $project->city . ', ' . $project->barangay) ?? 'N/A' }}</p>
@endif

{{-- Project Owner --}}
@if($project->owner)
    <h4 class="fw-bold text-primary">
        <i class="bi bi-person"></i> Project Owner
    </h4>
    <p class="mb-1"><strong>Name:</strong> {{ $project->owner->name ?? 'N/A' }}</p>
    <p class="mb-1"><strong>Phone:</strong> {{ $project->owner->contact_number ?? 'N/A' }}</p>
    <p class="mb-5"><strong>Email:</strong> {{ $project->owner->email ?? 'N/A' }}</p>
@endif
{{-- Assigned --}}
@if($project->worker)
    <h4 class="fw-bold text-primary">
        <i class="bi bi-check2-circle"></i> Assigned
    </h4>
    <p class="mb-1"><strong>Worker:</strong> {{ $project->worker->name ?? 'N/A' }}</p>
    <p class="mb-1"><strong>ID:</strong> {{ $project->worker->employeeCode() ?? 'N/A' }}</p>
@endif

<hr class="mt-5">