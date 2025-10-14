<?php

use App\Http\Controllers\WarehouseController;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ResourceController;

//TESTER
Route::get('/viewtest', function(){
    $availableItems = Item::all();
    return view('viewtest');
})->name('viewtest');

//User-account
Route::get('/login', function () {
    return Auth::check()
    ? redirect(route('/'))
    : view('auth/login');
});

Route::post('/login', [LoginController::class, 'login'] )->name('login');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/logout', [LoginController::class, 'logout'] )->name('logout');

// HOME
Route::get('/', [RedirectController::class, 'home'])
    ->name('home')
    ->middleware('auth');

// ADMIN
Route::middleware(['auth','role:admin'])->group(function(){
    // Redirect
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin');

    Route::get('/admin/user-management/', [RedirectController::class, 'admin_user_management'])
        ->name('admin.user-management');

    Route::get('/admin/projects/', [RedirectController::class, 'admin_projects'])
        ->name('admin.projects');

    Route::get('/admin/projects/view/{project_id}', [RedirectController::class, 'admin_project_view'])
        ->name('admin.project.view');
    
    Route::get('/admin/projects/edit/{project_id}', [RedirectController::class, 'admin_project_edit'])
        ->name('admin.project.edit');

    Route::get('/admin/warehouses/', [RedirectController::class, 'admin_warehouses'])
        ->name('admin.warehouses');

    // ---- Warehouse
    Route::post('/admin/warehouses/new', [WarehouseController::class, 'warehouse_new'])
        ->name('admin.warehouse.new');

    // ---- Requests
    Route::get('/admin/requests/new-resources', [RedirectController::class, 'requests_new_resources'])
        ->name('admin.requests.new-resources');

    Route::put('/admin/requests/new-resources/update/{resource_id}/{value}', [ResourceController::class, 'request_update_resource'])
        ->name('admin.requests.resources.update');
    

    // User Changes
    Route::put('/users/update/role/{user_id}', [UserController::class, 'admin_updateRole'])
        ->name('admin.user.updateRole');
    Route::post('/users/update/warehouse/{user_id}', [UserController::class, 'admin_updateWarehouse'])
        ->name('admin.user.updateWarehouse');
    Route::delete('/users/delete/warehouse/{user_id}', [UserController::class, 'admin_deleteWarehouse'])
        ->name('admin.user.deleteWarehouse');
    
    Route::delete('/users/{user_id}', [UserController::class, 'admin_destroy'])
        ->name('admin.user.destroy');

     // Project
    Route::post('/admin/project/new', [ProjectController::class, 'new'])->name('admin.project.new');
    Route::put('/admin/project/{project_id}/update/{submit}', [ProjectController::class, 'update'])->name('admin.project.update');
});

// WORKER
Route::middleware(['auth','role:admin,site_worker'])->group(function(){
    //Redirect
    Route::get('/worker/project/{project_id}/view/', [RedirectController::class, 'worker_project_view'])
        ->name('worker.project.view');
    Route::get('/worker/project/',[RedirectController::class, 'worker_projects'])
        ->name('worker.projects');
    Route::get('/worker/project/resource/edit/{resource_id}',[RedirectController::class, 'worker_resource_edit'])
        ->name('worker.resource.edit');
    Route::get('/worker/project/resource_item/add/{resource_id}', [RedirectController::class, 'worker_item_add'])
        ->name('worker.resource_item.add');
    Route::get('/worker/project/resource/verify/{resource_id}',[RedirectController::class, 'worker_project_verify'])
        ->name('worker.resource.verify');    

    //Actions
    Route::post('/worker/project/resource/new/{project_id}', [ResourceController::class, 'resource_new'])
        ->name('worker.resource.new');
    Route::put('/worker/project/resource/update/{resource_id}/{submit}', [ResourceController::class, 'resource_update'])
        ->name('worker.resource.update');
    Route::put('/worker/project/resource/verify/{resource_id}', [ResourceController::class, 'resource_verify_complete'])
        ->name('worker.resource.verify.complete');

    Route::post('/worker/project/resource_item/add/complete/{resource_id}', [ResourceController::class, 'item_add'])
        ->name('worker.resource_item.add.complete');
    Route::put('/worker/project/resource_item/update/{resource_id}', [ResourceController::class, 'item_update'])
        ->name('worker.resource_item.update');
    Route::delete('/worker/project/resource_item/delete/{resource_id}', [ResourceController::class, 'item_delete'])
        ->name('worker.resource_item.delete');

    //Request
    Route::post('project/{id}/request/accept', [ProjectController::class, 'accept'])->name('project.accept');
    Route::post('project/{id}/request/deny', [ProjectController::class, 'deny'])->name('project.deny');
});

// INVENTORY CLERK
Route::middleware(['auth','role:admin,inventory_clerk'])->group(function(){
    // Redirect
    Route::get('/clerk/projects/', [RedirectController::class, 'clerk_projects'])
        ->name('clerk.projects');;

    Route::get('/clerk/preparation/{resource_id}', [RedirectController::class, 'clerk_preparation'])
        ->name('clerk.preparation');
    
    Route::get('/clerk/inventory/', [RedirectController::class, 'clerk_inventory'])
        ->name('clerk.inventory');

    // Action
    Route::get('/clerk/resource/prepare/{resource_id}', [ResourceController::class, 'resource_prepare'])
        ->name('clerk.resource.prepare');

    Route::post('/clerk/preparation/prepare/{resource_id}', [ResourceController::class, 'resource_prepare_complete'])
        ->name('clerk.resource.prepare.complete');

    Route::put('/clerk/inventory/item/supply/', [ItemController::class, 'batch_supply'])
        ->name('clerk.inventory.supply');
});

// DRIVER
Route::middleware(['auth','role:admin,driver'])->group(function(){
    //Redirect
    Route::get('/driver/projects/', [RedirectController::class, 'driver_projects'])
        ->name('driver.projects');
    
    Route::get('/driver/project/delivery/{resource_id}', [RedirectController::class, 'driver_delivery'])
        ->name('driver.delivery');

    //Action
    Route::get('/driver/project/delivery/{resource_id}/{action}', [ResourceController::class, 'resource_delivery_update'])
        ->name('driver.delivery.update');

});