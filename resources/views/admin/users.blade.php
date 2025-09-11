@extends('admin.layouts.layout')

@section('title', 'User Management')

@section('content')<div class="container mt-4">
    <div class="container mt-4">
        <div class="card bg-dark text-light shadow">
            <div class="card-body">
                <h4 class="card-title mb-3">Inventory List</h4>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle">
                        <thead class="table-secondary text-dark">
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                                <tr>
                                    <td>{{ $index }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="align-middle">
                                        <form method="POST" action="{{ route('users.updateRole', $user->id) }}"
                                            class="d-flex align-items-center">
                                            @csrf
                                            @method('PUT')

                                            <!-- keep select reasonably wide but not so wide it pushes buttons to new line -->
                                            <select name="role" class="form-select form-select-sm me-3"
                                                style="max-width:420px; min-width:180px;">
                                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin
                                                </option>
                                                <option value="receiving_clerk" {{ $user->role === 'receiving_clerk' ? 'selected' : '' }}>Receiving Clerk
                                                </option>
                                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User
                                                </option>
                                                <!-- add other roles as needed -->
                                            </select>

                                            <button type="submit" class="btn btn-sm btn-success">Save</button>
                                        </form>
                                    </td>
                                    <td class="align-middle">
                                        <form method="POST" action="{{ route('users.destroy', $user->id) }}"
                                            onsubmit="return confirm('Remove this user?');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
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