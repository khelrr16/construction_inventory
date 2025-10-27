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
                <small class="text-muted d-block">{{ $status->created_at->format('F j, Y') }}</small>
            </div>
        </li>
    @empty
        No update.
    @endforelse
</ul>