<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Projects;
use App\Models\Warehouse;
use App\Models\WarehouseUser;
use App\Models\ProjectResource;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    public function home(){
        switch(Auth::user()->role){
            case 'admin':
                return redirect(route('admin'));
            case 'site_worker':
                return redirect(route('worker.projects'));
            case 'inventory_clerk':
                return redirect(route('clerk.requests'));
            case 'driver':
                return redirect(route('driver.pending'));
            default:
                return view('user');
        }
    }

    // ADMIN
    public function admin_projects(){
        $projects = Projects::all();
        return view('admin.projects', compact('projects'));
    }

    public function admin_project_view($project_id){
        $project = Projects::findOrFail($project_id);
        $resources = ProjectResource::where('project_id', $project_id)
            ->get()
            ->reverse();
        return view('admin.project-view', compact('project', 'resources'));
    }

    public function admin_project_edit($project_id){
        $project = Projects::findOrFail($project_id);
        $workers = User::where('role','site_worker')->get();
        return view('admin.project-edit', compact('project', 'workers'));
    }

    public function admin_user_management(){
        $users = User::all();
        $clerks = User::with('warehouse')->where('role','inventory_clerk')->get();
        $warehouses = Warehouse::all();
        $warehouse_users = WarehouseUser::all();
        return view('admin.users', compact('users','clerks','warehouses','warehouse_users'));
    }

    public function admin_warehouses(){
        $warehouses = Warehouse::all();
        return view('admin.warehouse.warehouses', compact('warehouses'));
    }

    public function admin_warehouse_view($warehouse_id){
        $warehouse = Warehouse::with(['users'])->findOrFail($warehouse_id);
        return view('admin.warehouse.warehouse-view', compact('warehouse'));
    }

    public function requests_new_resources(){
        $resources = ProjectResource::where('status','pending')
        ->with(['items','project'])
        ->get();
        $warehouses = Warehouse::all();
        return view('admin.requests.new-resources', compact('resources','warehouses'));
    }

    // SITE WORKER

    public function worker_projects(){
        $projects = auth()->guard()->user()->role == 'admin'
        ? Projects::where('status', 'processing')->get()
        : Projects::where('worker_id', auth()->guard()->user()->id)->get();
        
        return view('worker.projects', compact('projects'));
    }

    public function worker_project_view($project_id){
        $project = Projects::findOrFail($project_id);
        $resources = ProjectResource::with([
                'items',
                'warehouse',
                'creator',
                'preparer',
                'driver',
                'approver',
                'statusHistory',
            ])
            ->where('project_id', $project->id)
            ->get()
            ->reverse();
        
        $warehouses = Warehouse::where('status','active')->get();

        return view('worker.project-view', compact(['project','resources','warehouses']));
    }

    
    public function resource_add($resource_id){
        $resource = ProjectResource::with([
            'items',
            'project',
            ])
            ->findOrFail($resource_id);
        $usedItemIds = $resource->items->pluck('item_id');
        $resource->availableItems = Item::whereNotIn('id', $usedItemIds)->get();

        return view('worker.resource-edit',compact('resource'));
    }

    public function worker_resource_edit($resource_id){
        $resource = ProjectResource::with([
            'items',
            'project',
            'project.owner',
            'project.worker',
        ])
        ->findOrFail($resource_id);
        
        return view('worker.resource-edit',compact('resource'));
    }

    public function worker_item_add($resource_id){
        $resource = ProjectResource::with([
            'items',
            'project',
            'project.owner',
            'project.worker',
            'warehouse',
        ])
        ->findOrFail($resource_id);

        return view('worker.resource-add',compact(['resource']));
    }

    public function worker_project_verify($resource_id){
        $resource = ProjectResource::with([
            'items',
            'warehouse',
            'creator',
            'preparer',
            'driver',
            'approver',
        ])
        ->findOrFail($resource_id);

        return view('worker.resource-verify', compact('resource'));
    }

    // INVENTORY CLERK

    public function clerk_warehouses(){
        $warehouses = Warehouse::with(['users','items'])->get();
        return view('clerk.warehouses', compact('warehouses'));
    }

    public function clerk_requests()
    {   
        $user = auth()->guard()->user();
        
        if($user->role == 'admin'){
            $resources = ProjectResource::whereIn('status', ['pending','to be packed'])
                ->with([
                    'warehouse',
                    'items',
                    'preparer',
                    'driver',
                    'project.worker',
                    'project.owner'
                ])
                ->get();
        } else {
            $resources = ProjectResource::whereIn('status', ['pending','to be packed'])
                ->whereHas('warehouse.warehouseUsers', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->with([
                    'warehouse',
                    'items',
                    'preparer',
                    'driver',
                    'project.worker',
                    'project.owner'
                ])
                ->get();
        }

        return view('clerk.requests', compact('resources'));
    }

    public function clerk_preparation($resource_id){   
        $resource = ProjectResource::with([
            'items',
            'warehouse',
            'creator',
            'preparer',
            'driver',
            'approver',
            'project.worker',
        ])
        ->findOrFail($resource_id);
        $drivers = User::where('role','driver')->get();
        
        return view('clerk.preparation', compact('resource','drivers'));
    }

    public function clerk_inventory($warehouse_id){
        $warehouse = Warehouse::with('users')->findOrFail($warehouse_id);
        $items = Item::where('warehouse_id', $warehouse_id)->get();
        return view('clerk.inventory', compact('warehouse','items'));
    }
    
    public function clerk_item_edit($item_id){
        $item = Item::findOrFail($item_id);
        return view('clerk.item-edit', compact('item'));
    }

    // DRIVER

    public function driver_pending(){
        $user = auth()->guard()->user();

        if($user->role == 'admin'){
            $vehicles = Vehicle::all();
            $resources = ProjectResource::with([
                'items',
                'warehouse',
                'creator',
                'preparer',
                'driver',
                'approver',
                'project.worker',
            ])
            ->where('status','to be delivered')
            ->get();
        } else {
            $vehicles = Vehicle::where('registered_by', $user->id)->get();
            $resources = ProjectResource::with([
                'items',
                'warehouse',
                'creator',
                'preparer',
                'driver',
                'approver',
                'project.worker',
            ])
            ->where('driver_id', $user->id)
            ->where('status','to be delivered')
            ->get();
        }
        

        return view('driver.pending', compact('resources', 'vehicles'));
    }

    public function driver_deliveries(){
        $user = auth()->guard()->user();

        if($user->role == 'admin'){
            $resources = ProjectResource::with([
                'items',
                'warehouse',
                'creator',
                'preparer',
                'driver',
                'approver',
                'project.worker',
            ])
            ->where('status','on delivery')
            ->get();
        } else {
            $resources = ProjectResource::with([
                'items',
                'warehouse',
                'creator',
                'preparer',
                'driver',
                'approver',
                'project.worker',
            ])
            ->where('driver_id', $user->id)
            ->where('status','on delivery')
            ->get();
        }
        
        return view('driver.deliveries', compact('resources'));
    }

    public function driver_vehicles(){
        $vehicles = Vehicle::where('registered_by', auth()->guard()->id())
        ->get();

        return view('driver.vehicle.vehicles', compact('vehicles'));
    }

    public function driver_vehicle_edit($vehicle_id){
        $vehicle = Vehicle::findOrFail($vehicle_id);

        return view('driver.vehicle.vehicle-edit', compact('vehicle'));
    }
}
