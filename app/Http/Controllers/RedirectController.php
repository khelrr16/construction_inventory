<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
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
                return redirect(route('clerk.projects'));
            case 'driver':
                return redirect(route('driver.projects'));
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
        return view('admin.warehouses', compact('warehouses'));
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
        $projects = Projects::where('status', 'processing')->get();
        
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

        return view('worker.project-view', compact(['project','resources']));
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
        ])
        ->findOrFail($resource_id);
        $resource_items = $resource->items;
        $availableItems = Item::all();

        return view('worker.resource-add',compact(['resource', 'availableItems']));
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

    public function clerk_projects(){
        $warehouses = Warehouse::with([
            'pendingResources.items',
            'pendingResources.preparer',
            'pendingResources.driver',
            'pendingResources.project.worker',
            'pendingResources.project.owner'
        ])->get();

        return view('clerk.projects', compact('warehouses'));
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

    public function clerk_inventory(){
        $items = Item::all();
        return view('clerk.inventory', compact('items'));
    }

    // DRIVER

    public function driver_projects(){
        $resources = ProjectResource::with([
                'items',
                'warehouse',
                'creator',
                'preparer',
                'driver',
                'approver',
                'project.worker',
            ])
            ->whereIn('status',['to be delivered', 'on delivery'])
            ->get();

        return view('driver.projects', compact('resources'));
    }

    public function driver_delivery($resource_id){
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

        return view('driver.delivery', compact('resource'));
    }
}
