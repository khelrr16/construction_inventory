@extends('layouts.admin.layout')

@section('title', 'User Management')

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

    <div class="container mt-5">
        <ul class="nav nav-tabs" id="userWarehouseTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users"
                    type="button" role="tab" aria-controls="users" aria-selected="true">
                    Users
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="warehouse-tab" data-bs-toggle="tab" data-bs-target="#warehouse"
                    type="button" role="tab" aria-controls="warehouse" aria-selected="false">
                    Warehouse Assignment
                </button>
            </li>
        </ul>

        <div class="tab-content" id="userWarehouseTabsContent">
            <!-- USERS TAB -->
            <div class="tab-pane fade show active p-3" id="users" role="tabpanel" aria-labelledby="users-tab">
                <h4 class="mb-3">Users</h4>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th style="width: 180px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <form action="{{ route('admin.user.updateRole', $user->id) }}" method="POST"
                                            class="d-flex">
                                            @csrf @method('PUT')
                                            <select name="role" class="form-select me-2">
                                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User
                                                </option>
                                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin
                                                </option>
                                                <option value="driver" {{ $user->role == 'driver' ? 'selected' : '' }}>Driver
                                                </option>
                                                <option value="inventory_clerk" {{ $user->role == 'inventory_clerk' ? 'selected' : '' }}>Inventory Clerk</option>
                                                <option value="site_worker" {{ $user->role == 'site_worker' ? 'selected' : '' }}>Site Worker</option>
                                            </select>
                                            <button type="submit" class="btn btn-success btn-sm">Save</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- WAREHOUSE ASSIGNMENT TAB -->
            <div class="tab-pane fade p-3" id="warehouse" role="tabpanel" aria-labelledby="warehouse-tab">
                <h4 class="mb-3">Warehouse Assignment</h4>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">No.</th>
                                <th>Inventory Clerks</th>
                                <th>Assigned Warehouse</th>
                                <th style="width: 180px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clerks as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        <form action="{{ route('admin.user.updateWarehouse', $user->id) }}" method="POST"
                                            class="d-flex">
                                            @csrf
                                            <select name="warehouse_id" class="form-select me-2">
                                                <option disabled {{ $user->warehouse ? '' : 'selected' }}>--</option>
                                                @foreach($warehouses as $warehouse)
                                                    <option value="{{ $warehouse->id }}" {{ $user->warehouse ? ($user->warehouse->warehouse_id == $warehouse->id ? 'selected' : '') : '' }}>
                                                        {{ $warehouse->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn btn-primary btn-sm">Assign</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.user.deleteWarehouse', $user->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection