@extends('layouts.layout')

@section('title', 'Title')

@section('content')

    <div class="container mt-0 mt-sm-4">
        <div class="mb-3">
            <h4>Project Name: <span class="text-primary">{{$project->project_name}}</span></h4>
        </div>

        <div class="card bg-dark text-white mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Resources</h5>
                <!-- Add Material Button -->
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#materialModal">
                    Add Material
                </button>
            </div>

            <div class="card-body p-0">
                <table class="table table-dark table-striped mb-0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Cost</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="resourceTable">
                        @forelse($project_items as $index => $item)
                            <tr>
                                <th>{{$index}}</th>
                                <th>{{$item->category}}</th>
                                <th>{{$item->name}}</th>
                                <th>{{$item->description}}</th>
                                <th>{{$item->cost}}</th>
                                <th>{{$item->quantity}}</th>
                                <th>??</th>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Empty resources</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Request Button -->
        <div class="mt-3">
            <button class="btn btn-success">Request</button>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="materialModal" tabindex="-1" aria-labelledby="materialModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-dark text-white">
                <form action="{{route('project_items.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="materialModalLabel">Select Materials</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <table class="table table-dark table-hover align-middle" id="materialsTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Measure</th>
                                    <th>Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $index => $item)
                                    <tr onclick="toggleSelect(this)">
                                        <td class="d-none">
                                            <input type="checkbox" name="resources[]" value="{{ $item->id }}">
                                        </td>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->category }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->measure }}</td>
                                        <td>₱{{ number_format($item->cost) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="8">Resources unavailable</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Insert</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function toggleSelect(row) {
            let checkbox = row.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
            if (checkbox.checked) {
                row.classList.add("table-success");
            } else {
                row.classList.remove("table-success");
            }
        }
    </script>
@endsection