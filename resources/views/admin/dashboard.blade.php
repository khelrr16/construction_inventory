@extends('layouts.admin.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="container py-4">
      {{-- Metrics Row --}}
      <div class="row g-3 mb-4">
        <div class="col-md-3">
          <div class="card card-metric p-3">
            <div class="d-flex justify-content-between">
              <small class="text-muted">Total Items</small>
              <i class="bi bi-box"></i>
            </div>
            <h4 class="fw-bold">1,247</h4>
            <small class="text-success">+12% from last month</small>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card card-metric p-3">
            <div class="d-flex justify-content-between">
              <small class="text-muted">Items Received Today</small>
              <i class="bi bi-graph-up-arrow"></i>
            </div>
            <h4 class="fw-bold">23</h4>
            <small class="text-success">+5 from yesterday</small>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card card-metric p-3">
            <div class="d-flex justify-content-between">
              <small class="text-muted">Low Stock Items</small>
              <i class="bi bi-exclamation-triangle"></i>
            </div>
            <h4 class="fw-bold">8</h4>
            <small class="text-warning">3 critical</small>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card card-metric p-3">
            <div class="d-flex justify-content-between">
              <small class="text-muted">Completed Deliveries</small>
              <i class="bi bi-check-circle"></i>
            </div>
            <h4 class="fw-bold">156</h4>
            <small class="text-success">+8 this week</small>
          </div>
        </div>
      </div>

      {{-- Recent Activity --}}
      <div class="card recent-card">
        <div class="card-header bg-white fw-bold">Recent Activity</div>
        <ul class="list-group list-group-flush">
          <li class="list-group-item d-flex justify-content-between align-items-start">
            <div>
              <span class="dot"></span>
              <strong>Steel Beams - 20ft</strong>
              <div class="text-muted small">Received 15 units</div>
            </div>
            <small class="text-muted">2 hours ago</small>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-start">
            <div>
              <span class="dot"></span>
              <strong>Concrete Mix - 50lb bags</strong>
              <div class="text-muted small">Received 100 units</div>
            </div>
            <small class="text-muted">4 hours ago</small>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-start">
            <div>
              <span class="dot"></span>
              <strong>Safety Helmets</strong>
              <div class="text-muted small">Received 60 units</div>
            </div>
            <small class="text-muted">6 hours ago</small>
          </li>
        </ul>
      </div>
    </div>

    {{-- Bootstrap Icons CDN --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
@endsection