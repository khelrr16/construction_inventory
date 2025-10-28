<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\AuditLog;
use App\Models\Warehouse;
use App\Models\ProjectResource;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();

        // Key Metrics
        $metrics = [
            'total_warehouses' => Warehouse::count(),
            'total_users' => User::count(),
            'total_vehicles' => Vehicle::count(),
            'total_items' => Item::count(),
            'active_deliveries' => ProjectResource::whereIn('status', ['delivering', 'in transit'])->count(),
            'pending_requests' => ProjectResource::where('status', 'pending')->count(),
            'weekly_deliveries' => ProjectResource::where('created_at', '>=', $startOfWeek)->count(),
            'monthly_deliveries' => ProjectResource::where('created_at', '>=', $startOfMonth)->count(),
        ];

        // Delivery Statistics
        $deliveryStats = [
            'pending' => ProjectResource::where('status', 'pending')->count(),
            'packing' => ProjectResource::where('status', 'packing')->count(),
            'delivering' => ProjectResource::where('status', 'delivering')->count(),
            'delivered' => ProjectResource::where('status', 'delivered')->count(),
            'cancelled' => ProjectResource::where('status', 'cancelled')->count(),
        ];

        // Recent Activities
        // $recentActivities = ProjectResource::with(['project', 'driver', 'warehouse'])
        //     ->latest()
        //     ->take(10)
        //     ->get();
        $recentActivities = AuditLog::with('user')
            ->latest()
            ->limit(50)
            ->get();

        // Warehouse-wise Statistics
        $warehouseStats = Warehouse::withCount([
            'projectResources as pending_count' => function($query) {
                $query->where('status', 'pending');
            },
            'projectResources as delivering_count' => function($query) {
                $query->where('status', 'delivering');
            },
            'projectResources as delivered_count' => function($query) {
                $query->where('status', 'delivered');
            },
            'items as low_stock_items' => function($query) {
                $query->where('stocks', '<', 10); // Items with less than 10 stock
            }
        ])->get();

        // Weekly Delivery Chart Data
        $weeklyData = $this->getWeeklyDeliveryData();

        $statusColors = [
            'pending' => 'warning',
            'packing' => 'info', 
            'delivering' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger'
        ];

        return view('admin.dashboard', compact(
            'metrics',
            'deliveryStats',
            'recentActivities',
            'warehouseStats',
            'weeklyData',
            'statusColors'
        ));
    }

    private function getWeeklyDeliveryData()
    {
        $data = [];
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $data['labels'][] = $date->format('D');
            $data['deliveries'][] = ProjectResource::whereDate('created_at', $date)->count();
            $data['completed'][] = ProjectResource::whereDate('updated_at', $date)
                ->where('status', 'delivered')
                ->count();
        }

        return $data;
    }
}