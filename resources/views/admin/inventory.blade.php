@extends('admin.layouts.layout')

@section('title', 'Inventory')

@section('content')

  @if(session('success'))
      <p style="color:green">{{ session('success') }}</p>
  @endif

  <div class="container mt-4">
    <div class="card shadow p-4">
    <h4 class="mb-3">Add Inventory Item</h4>
    <form>
      <div class="mb-3">
        <label class="form-label">Category</label>
        <select class="form-select">
          <option>Material</option>
          <option>Tool</option>
          {{-- <option>Equipment</option> --}}
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" placeholder="Enter item name">
      </div>

      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" rows="3" placeholder="Enter item description"></textarea>
      </div>

      <div class="row">
      <div class="col-md-4 mb-3">
      <label class="form-label">Cost</label>
      <input type="number" class="form-control" placeholder="₱0.00">
      </div>
      <div class="col-md-4 mb-3">
      <label class="form-label">Measure</label>
      <input type="text" class="form-control" placeholder="e.g. kg, pcs">
      </div>
      <div class="col-md-4 mb-3">
      <label class="form-label">Stocks</label>
      <input type="number" class="form-control" placeholder="0">
      </div>
      </div>

      <button type="submit" class="btn btn-primary">Add Item</button>
    </form>
    </div>
  </div>
    <div class="container mt-4">
        <div class="card bg-dark text-light shadow">
            <div class="card-body">
            <h4 class="card-title mb-3">Inventory List</h4>
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle">
                <thead class="table-secondary text-dark">
                    <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Cost</th>
                    <th>Measure</th>
                    <th>Stocks</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $index => $item)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $item->category }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->cost }}</td>
                        <td>{{ $item->measure }}</td>
                        <td>{{ $item->stocks }}</td>
                        <td>
                            <a href="{{ route('items.edit', $item->id) }}" class="btn btn-sm btn-outline-info me-2">Edit</a>
                            <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="7">No items yet</td>
                        </tr>
                    @endforelse
                </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>

@endsection