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
        . ', ' . $resource->warehouse->zipcode }}
                    <br> {{ $resource->warehouse->barangay
        . ', ' . $resource->warehouse->city
        . ', ' . $resource->warehouse->province }}
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