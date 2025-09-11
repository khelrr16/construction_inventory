@extends('layouts.layout')

@section('title', 'Home')

@section('content')
  @if(Auth::check() && Auth::user()->role === 'admin')
    <a href="{{ route('admin') }}">Go to Admin Dashboard</a>
  @endif
  
  {{-- <p><a href="{{route('project')}}">New Project</a></p> --}}


  <div class="container mt-0 mt-sm-4">
    <form action="{{route('project.new')}}" method="POST" class="input-group mb-3" style="max-width: 400px;">
      @csrf
      <input name="project_name" type="text" class="form-control" placeholder="Project Name" aria-label="Project Name">
      <button class="btn btn-primary" type="submit">Add</button>
    </form>

    <div class="card bg-dark text-light shadow">
      <div class="card-body">
        <h4 class="card-title mb-3">Projects</h4>
        <div class="table-responsive">
          <table class="table table-dark table-hover align-middle">
            <thead class="table-secondary text-dark">
              <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($projects as $index => $project)
                <tr>
                  <td>{{ $index }}</td>
                  <td>{{ $project->project_name }}</td>
                  <td>
                    <a href="{{route('project.view', $project->id)}}" class="btn btn-sm btn-outline-info me-2">View</a>
                    <form action="" method="POST" style="display:inline;">
                      <button class="btn btn-sm btn-danger">Remove</button>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td class="text-center" colspan="7">No projects yet</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection