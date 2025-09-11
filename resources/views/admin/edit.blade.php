@extends('admin.layouts.layout')

@section('title', 'Edit')

@section('content')
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-primary text-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="card shadow p-4">
            <h4 class="mb-3">Add Inventory Item</h4>
            <form action="{{route('items.update',$item->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select">
                        <option value="material" @if(old('category') === 'material') selected @endif>Material</option>
                        <option value="tool" @if(old('category') === 'tool') selected @endif>Tool</option>
                        {{-- <option>Equipment</option> --}}
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input value="{{$item->name}}" name="name" type="text" class="form-control" placeholder="Enter item name">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Enter item description">{{$item->description}}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cost</label>
                        <input value="{{$item->cost}}" name="cost" type="number" class="form-control" placeholder="₱0.00">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Measure</label>
                        <input value="{{$item->measure}}" name="measure" type="text" class="form-control" placeholder="e.g. kg, pcs">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Stocks</label>
                        <input value="{{$item->stocks}}" name="stocks" type="number" class="form-control" placeholder="0">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Add Item</button>
            </form>
        </div>
    </div>
@endsection