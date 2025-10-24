@extends('layouts.clerk.layout')

@section('title', 'Warehouses')

@section('styles')
    <style>
        .warehouse-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            height: 100%;
        }
        .warehouse-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-bottom: none;
        }
    </style>
@endsection

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

    <div class="container py-4 fs-5">
        <div class="row">
            @forelse ($warehouses as $warehouse)
                <!-- Warehouse 7 -->    
                <div class="col-9 col-md-6 mb-4">
                    <div class="card warehouse-card h-100">
                        <div class="card-header p-3">
                            <h5 class="card-title mb-0">{{ $warehouse->name }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-geo-alt"></i>
                                    <small>
                                        {{ $warehouse->house.', '.$warehouse->zipcode}}
                                        <br>
                                        {{ $warehouse->barangay.', '.$warehouse->city.', '.$warehouse->province }}
                                    </small>
                                </div>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-box-seam"></i>
                                    <small>{{ count($warehouse->items) }} item/s</small>
                                </div>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <i class="bi bi-people text-muted"></i>
                                    <small>{{ count($warehouse->users) }} member/s</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-success">Active</span>
                                <div class="btn-group">
                                    <a href="{{ route('clerk.inventory', $warehouse->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <h3>No warehouses.</h3>
            @endforelse
        </div>
        
    </div>
@endsection