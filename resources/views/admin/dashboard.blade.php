@extends('layouts.admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <span class="text-muted">Last updated: {{ now()->format('M j, Y g:i A') }}</span>
    </div>

    <!-- Metrics Cards -->
    <div class="row">
        <!-- Total Warehouses -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Warehouses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $metrics['total_warehouses'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-warehouse fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Deliveries -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Active Deliveries</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $metrics['active_deliveries'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-truck fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Pending Requests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $metrics['pending_requests'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Weekly Deliveries -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Weekly Deliveries</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $metrics['weekly_deliveries'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Detailed Stats -->
    <div class="row">
        <!-- Delivery Status Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Delivery Status Distribution</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="deliveryStatusChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @foreach($deliveryStats as $status => $count)
                        <span class="mr-2">
                            <i class="fas fa-circle"></i> 
                            {{ ucfirst($status) }} ({{ $count }})
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Weekly Delivery Chart -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Weekly Delivery Trend</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="weeklyDeliveryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Warehouse Statistics -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Warehouse Performance</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="warehouseTable">
                            <thead>
                                <tr>
                                    <th>Warehouse</th>
                                    <th>Pending</th>
                                    <th>Delivering</th>
                                    <th>Delivered</th>
                                    <th>Low Stock Items</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($warehouseStats as $warehouse)
                                <tr>
                                    <td>{{ $warehouse->name }}</td>
                                    <td>{{ $warehouse->pending_count }}</td>
                                    <td>{{ $warehouse->delivering_count }}</td>
                                    <td>{{ $warehouse->delivered_count }}</td>
                                    <td>
                                        <span class="badge badge-{{ $warehouse->low_stock_items > 0 ? 'danger' : 'success' }}">
                                            {{ $warehouse->low_stock_items }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">Active</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- Recent Activities -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Activities</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($recentActivities as $activity)
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <strong>#{{ $activity->id }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $activity->project->name ?? 'N/A' }}</small>
                                </div>
                                <div class="col-md-3">
                                    <span class="badge">
                                        {{ ucfirst($activity->status) }}
                                    </span>
                                </div>
                                <div class="col-md-3">
                                    <small>Driver: {{ $activity->driver->name ?? 'Not assigned' }}</small>
                                </div>
                                <div class="col-md-3 text-right">
                                    <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Delivery Status Pie Chart
var ctx = document.getElementById('deliveryStatusChart').getContext('2d');
var deliveryStatusChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Packing', 'Delivering', 'Delivered', 'Cancelled'],
        datasets: [{
            data: [
                {{ $deliveryStats['pending'] }},
                {{ $deliveryStats['packing'] }},
                {{ $deliveryStats['delivering'] }},
                {{ $deliveryStats['delivered'] }},
                {{ $deliveryStats['cancelled'] }}
            ],
            backgroundColor: ['#f6c23e', '#fd7e14', '#36b9cc', '#1cc88a', '#e74a3b'],
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// Weekly Delivery Line Chart
var ctx2 = document.getElementById('weeklyDeliveryChart').getContext('2d');
var weeklyDeliveryChart = new Chart(ctx2, {
    type: 'line',
    data: {
        labels: @json($weeklyData['labels']),
        datasets: [{
            label: 'Deliveries Created',
            data: @json($weeklyData['deliveries']),
            borderColor: '#4e73df',
            backgroundColor: 'rgba(78, 115, 223, 0.1)',
            fill: true
        }, {
            label: 'Deliveries Completed',
            data: @json($weeklyData['completed']),
            borderColor: '#1cc88a',
            backgroundColor: 'rgba(28, 200, 138, 0.1)',
            fill: true
        }]
    },
    options: {
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>
@endpush