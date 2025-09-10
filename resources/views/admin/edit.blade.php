@extends('admin.layouts.layout')

@section('title', 'Edit')

@section('content')

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form action="{{ route('items.update', ['id' => $item->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Category:</label>
        <select name="category" required>
            <option value="material" @if(old('category') === 'material') selected @endif>Material</option>
            <option value="tool" @if(old('category') === 'tool') selected @endif>Tool</option>
        </select><br>

        <label>Name:</label>
        <input type="text" name="name" value="{{$item->name}}" required><br>

        <label>Description:</label>
        <textarea name="description">{{$item->description}}</textarea><br>

        <label>Cost:</label>
        <input type="number" name="cost" value="{{$item->cost}}" step="0.01" required><br>

        <label>Measure:</label>
        <input type="text" name="measure" value="{{$item->measure}}" required><br>

        <label>Stocks:</label>
        <input type="text" name="stocks" value="{{$item->stocks}}" required><br>

        <a href="{{route('admin.inventory')}}">Cancel</a>
        <button type="submit">Update Item</button>
    </form>
@endsection