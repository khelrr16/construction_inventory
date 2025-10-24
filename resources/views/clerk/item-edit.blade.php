@extends('layouts.clerk.layout')

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
    
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h2 class="card-title mb-0 fw-bold">
                    <a href="{{ route('clerk.inventory', $item->warehouse_id) }}"
                        class="text-decoration-none">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    Item Edit
                </h2>
            </div>

        <form action="{{ route('clerk.inventory.item.update', $item->id) }}" method="POST">
            @csrf
            <div class="card-body">
                <!-- Material -->
                <div class="mt-4">
                    <label for="category" class="form-label fw-bold">Category</label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="material" {{ $item->category == 'material' ? 'selected' : ''}}>
                            Material
                        </option>

                        <option value="tool" {{ $item->category == 'tool' ? 'selected' : ''}}>
                            Tool
                        </option>
                    </select>
                </div>
                
                <!-- Name -->
                <div class="mt-4">
                    <label for="name" class="form-label fw-bold">Name</label>
                    <input value="{{ $item->name }}" required type="text" name="name" id="name" class="form-control">
                </div>

                <!-- Description -->
                <div class="col-12 mt-4">
                    <label for="description" class="form-label fw-bold">Description</label>
                    <textarea required name="description" id="description" class="form-control" rows="4"
                    >{{ $item->description }}</textarea>
                </div>

                <!-- Cost -->
                <div class="mt-4">
                    <label for="cost" class="form-label fw-bold">Cost</label>
                    <input value="{{ $item->cost }}" required type="number" name="cost" id="cost" class="form-control">
                </div>
                
                <!-- Measure -->
                <div class="mt-4">
                    <label for="measure" class="form-label fw-bold">Measurement</label>
                    <input value="{{ $item->measure }}" required type="text" name="measure" id="measure" class="form-control">
                </div>

                <!-- Stocks -->
                <div class="mt-4">
                    <label for="stocks" class="form-label fw-bold">Stocks</label>
                    <input value="{{ $item->stocks }}" required type="number" name="stocks" id="stocks" class="form-control">
                </div>
            </div>

            <div class="card-footer">
                <button onclick="this.disabled=true;this.form.submit()"
                    type="submit" class="btn btn-success w-100">Save</button>
            </div>
        </form>
    </div>

    <script>
        function toggleSelect(row) {
            const checkbox = row.querySelector('input[type=checkbox]');
            checkbox.checked = !checkbox.checked;
            row.classList.toggle('table-primary', checkbox.checked);
        }

        function toggleRemove(row) {
            const checkbox = row.querySelector('input[type=checkbox]');
            checkbox.checked = !checkbox.checked;
            row.querySelectorAll('td').forEach(td => {
                td.classList.toggle('bg-danger', checkbox.checked);
                td.classList.toggle('text-white', checkbox.checked);
            });
        }

        // Batch Supply Modal
        document.getElementById('supplyModal').addEventListener('hidden.bs.modal', function () {

            // Uncheck all checkboxes inside the modal
            this.querySelectorAll('input[type="number"]').forEach(inp => inp.value = null);
        });

        // Batch Delete Modal
        document.getElementById('deleteModal').addEventListener('hidden.bs.modal', function () {

            // Uncheck all checkboxes inside the modal
            this.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);

            // Also remove any "active" highlight if your toggleRemove() adds one
            this.querySelectorAll('td.bg-danger').forEach(td => td.classList.remove('bg-danger','text-white'));
        });

    </script>
@endsection