@extends('layouts.others.layout')

@section('title', 'Title')

@section('content')
    <div class="container mt-5 fs-5">
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
        
        <div class="card shadow-sm mb-4">
            {{-- Header --}}
            <div class="card-header d-flex justify-content-between align-items-start"
                data-bs-toggle="collapse" 
                data-bs-target="#resource" 
                aria-expanded="false" 
                aria-controls="resource" 
                style="cursor: pointer;">

                <div>
                    <h2 class="card-title mb-0 fw-bold">
                        {{ $resource->project->project_name }} 
                        <span class="badge bg-warning mt-2 fs-5">{{ ucwords($resource->status) }}</span>
                    </h2>
                    <p class="mt-2"><i>Remarks:</i> {{ $resource->remark ?? 'N/A'}} </p>

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

            <div id="resource" class="collapse">
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
                    <p class="mb-1"><strong>ID:</strong> {{ $resource->project->worker->employeeCode() ?? 'N/A' }}</p>

                    <hr class="mt-5">
                </div>
            </div>

            <!-- Table -->
            <div class="card-body">
                <form action="{{route('clerk.resource.prepare.complete', $resource->id)}}" method="POST">
                    @csrf
                    <!-- Resources Table -->
                    <div class="card shadow-sm" id="resourcesTable">
                        <div
                            class="card-header d-flex justify-content-between align-items-center bg-secondary text-white">
                            <h5 class="mb-0"
                                style="cursor:pointer;"
                                data-bs-toggle="modal" 
                                data-bs-target="#resourceDetailsModal">
                                Resource {{ $resource->id }} <i class="bi bi-info-circle"></i></h5>
                        </div>

                        <!-- Display Table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle text-center mb-0 fw-bold">
                                <thead class="table-dark text-white">
                                    <tr>
                                        <th class="col-1">No.</th>
                                        <th class="col-2">Name</th>
                                        <th class="col-4">Description</th>
                                        <th class="col-1">Quantity</th>
                                        <th class="col-1">Supply</th>
                                        <th class="col-1">Stocks</th>
                                        <th class="col-1">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($resource->items as $item_index => $item)
                                        <tr>
                                            <!-- No. -->
                                            <td>{{ $item_index + 1 }}</td>
                                            <!-- Name -->
                                            <td class="text-start">
                                                @if($item->details->category === 'material')
                                                    <i class="bi bi-box"></i>
                                                @else
                                                    <i class="bi bi-wrench"></i>
                                                @endif
                                                {{ $item->details->name }}
                                            </td>
                                            <!-- Description -->
                                            <td class="text-start">{{ $item->details->description }}</td>
                                            <!-- Quantity -->
                                            <td>
                                                {{ $item->quantity . ' ' . $item->details->measure}}
                                            </td>
                                            <!-- Supply -->
                                            <td>
                                                <input 
                                                    type="number" 
                                                    class="form-control qty-input" 
                                                    min="0"
                                                    name="supplied[{{$item->id}}]"
                                                    data-success-threshold="{{$item->quantity}}"
                                                    data-stocks-threshold="{{$item->details->stocks}}"
                                                    value="{{$item->supplied}}"
                                                >
                                            </td>
                                            <!-- Stocks -->
                                            <td>
                                                {{ $item->details->stocks . ' ' . $item->details->measure}}
                                            </td>
                                            <!-- Status -->
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

                    <div class="mx-auto my-3 w-50">
                        <label for="driver" class="form-label fw-bold">Assign Driver</label>
                        <select name="driver_id" id="driver" class="form-control" required>
                            <option selected disabled>--Driver--</option>
                            @if($drivers)
                                @foreach($drivers as $driver)
                                    <option 
                                        @if($resource->driver_id == $driver->id) selected @endif 
                                        value="{{ $driver->id }}">
                                        {{$driver->employeeCode().' | '.$driver->email}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Button trigger modal -->
                    <button type="submit" class="btn btn-primary w-100 w-sm-auto">
                        Complete Preparation
                    </button>
                </form>
            </div>

            <!-- Details Modal -->
            <div class="modal fade" id="resourceDetailsModal" tabindex="-1" aria-labelledby="resourceDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="resourceDetailsModal">
                                Resource Details
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
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
                                    .', '.$resource->warehouse->zipcode }}
                                    <br> {{ $resource->warehouse->barangay
                                    .', '.$resource->warehouse->city
                                    .', '.$resource->warehouse->province }}
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function updateRowColor(input) {
                const tr = input.closest('tr');
                if (!tr) return;
                
                const val = input.value === '' ? null : Number(input.value);
                const success = Number(input.dataset.successThreshold);
                const stocks = Number(input.dataset.stocksThreshold);

                tr.querySelectorAll('td').forEach(td => {
                    td.classList.remove('bg-success', 'bg-warning', 'bg-danger', 'text-white');
                });

                if (val === null) return;

                let classes = [];
                if (val > stocks) {
                    classes = ['bg-danger','text-white'];
                } else if (val === success) {
                    classes = ['bg-success','text-white'];
                } else {
                    classes = ['bg-warning'];
                }

                // apply color to each td
                tr.querySelectorAll('td').forEach(td => {
                    td.classList.add(...classes);
                });
            }
            
            document.querySelectorAll('.qty-input').forEach(function (input) {
                // run function every key press/release
                input.addEventListener('input', function () {
                    updateRowColor(input);
                });

                // run on page load
                updateRowColor(input);
            });
        });
    </script>
@endsection