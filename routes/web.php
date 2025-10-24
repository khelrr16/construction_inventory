<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ForgotPasswordController;

//TESTER
// Route::get('/test-mail', function() {
//     try {
//         Mail::raw('Test email body', function($message) {
//             $message->to('truemichael.liking@gmail.com')
//                 ->subject('Test Email from Laravel');
//         });
        
//         return '✅ Email sent successfully!';
        
//     } catch (\Exception $e) {
//         // Detailed error information
//         return '❌ Email failed: ' . $e->getMessage() . 
//             '<br><br>Full error:<br><pre>' . $e . '</pre>';
//     }
// });

//User-account
Route::get('/login', function () {
    return Auth::check()
    ? redirect(route('home'))
    : view('auth/login');
});

Route::get('/forgot-password', [ForgotPasswordController::class, 'showEmailForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendCode'])->name('password.send.code');
Route::get('/verify-code', [ForgotPasswordController::class, 'showVerifyForm'])->name('password.verify.form');
Route::post('/verify-code', [ForgotPasswordController::class, 'verifyCode'])->name('password.verify.code');
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset');


Route::post('/login', [LoginController::class, 'login'] )->name('login');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/logout', [LoginController::class, 'logout'] )->name('logout');

// HOME
Route::get('/', [RedirectController::class, 'home'])
    ->name('home')
    ->middleware('auth');

// ADMIN
Route::middleware(['auth', 'can:access-admin'])->group(function(){
    // Redirect
    Route::get('/admin', [DashboardController::class, 'adminDashboard'])
        ->name('admin');

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
    
    Route::get('/admin/warehouses/{warehouse_id}', [RedirectController::class, 'admin_warehouse_view'])
        ->name('admin.warehouse.view');

    // ---- Warehouse
    Route::post('/admin/warehouses/new', [WarehouseController::class, 'warehouse_new'])
        ->name('admin.warehouse.new');

    // ---- Requests
    Route::get('/admin/requests/new-resources', [RedirectController::class, 'requests_new_resources'])
        ->name('admin.requests.new-resources');

    Route::put('/admin/requests/new-resources/update/{resource_id}/{value}', [ResourceController::class, 'request_update_resource'])
        ->name('admin.requests.resources.update');
    
    // User Changes
    Route::put('/admin/users/role/role/{user_id}', [UserController::class, 'admin_updateRole'])
        ->name('admin.user.updateRole');
    Route::post('/admin/users/warehouse-assignment/update/{user_id}', [UserController::class, 'admin_updateWarehouse'])
        ->name('admin.user.updateWarehouse');
    Route::delete('/admin/users/warehouse-assignment/delete/{user_id}', [UserController::class, 'admin_deleteWarehouse'])
        ->name('admin.user.deleteWarehouse');
    
    Route::delete('/admin/users/delete/{user_id}', [UserController::class, 'admin_destroy'])
        ->name('admin.user.destroy');

     // Project
    Route::post('/admin/project/new', [ProjectController::class, 'new'])->name('admin.project.new');
    Route::put('/admin/project/{project_id}/update/{submit}', [ProjectController::class, 'update'])->name('admin.project.update');
});

// WORKER
Route::middleware(['auth', 'can:access-worker'])->group(function(){
    
    //Redirect
    Route::get('/worker/project/',[RedirectController::class, 'worker_projects'])
        ->name('worker.projects');
    Route::get('/worker/project/{project_id}/view/', [RedirectController::class, 'worker_project_view'])
        ->name('worker.project.view')
        ->middleware('worker.project');
    Route::get('/worker/project/resource/edit/{resource_id}',[RedirectController::class, 'worker_resource_edit'])
        ->name('worker.resource.edit')
        ->middleware('worker.resource');
    Route::get('/worker/project/resource_item/add/{resource_id}', [RedirectController::class, 'worker_item_add'])
        ->name('worker.resource_item.add')
        ->middleware('worker.resource');
    Route::get('/worker/project/resource/verify/{resource_id}',[RedirectController::class, 'worker_project_verify'])
        ->name('worker.resource.verify')
        ->middleware('worker.resource');

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
});

// INVENTORY CLERK
Route::middleware(['auth', 'can:access-inventory-clerk'])->group(function(){
    // Redirect
    Route::get('/clerk/warehouses/', [RedirectController::class, 'clerk_warehouses'])
        ->name('clerk.warehouses');

    Route::get('/clerk/requests/', [RedirectController::class, 'clerk_requests'])
        ->name('clerk.requests');

    Route::get('/clerk/preparation/{resource_id}', [RedirectController::class, 'clerk_preparation'])
        ->name('clerk.preparation');
    
    Route::get('/clerk/inventory/{warehouse_id}', [RedirectController::class, 'clerk_inventory'])
        ->name('clerk.inventory');
    
    Route::get('/clerk/inventory/item/{item_id}', [RedirectController::class, 'clerk_item_edit'])
        ->name('clerk.inventory.item.edit');

    // Action
    Route::get('/clerk/resource/prepare/{resource_id}', [ResourceController::class, 'resource_prepare'])
        ->name('clerk.resource.prepare');

    Route::post('/clerk/preparation/prepare/{resource_id}', [ResourceController::class, 'resource_prepare_complete'])
        ->name('clerk.resource.prepare.complete');

    Route::post('/clerk/inventory/csv/upload/{warehouse_id}', [ItemController::class, 'clerk_uploadCSV'])
        ->name('clerk.inventory.upload');

    Route::post('/clerk/inventory/item/add/{warehouse_id}', [ItemController::class, 'clerk_add'])
        ->name('clerk.inventory.item.add');
    
    Route::post('/clerk/inventory/item/update/{item_id}', [ItemController::class, 'clerk_update'])
        ->name('clerk.inventory.item.update');

    Route::put('/clerk/inventory/item/supply/', [ItemController::class, 'batch_supply'])
        ->name('clerk.inventory.supply');

    Route::delete('/clerk/inventory/item/delete/', [ItemController::class, 'batch_delete'])
        ->name('clerk.inventory.delete');
});

// DRIVER
Route::middleware(['auth', 'can:access-driver'])->group(function(){
    //Redirect
    Route::get('/driver/pending/', [RedirectController::class, 'driver_pending'])
        ->name('driver.pending');
    
    Route::get('/driver/deliveries/', [RedirectController::class, 'driver_deliveries'])
        ->name('driver.deliveries');

    Route::get('/driver/vehicles/', [RedirectController::class, 'driver_vehicles'])
        ->name('driver.vehicles');
    
    Route::get('/driver/vehicle/edit/{vehicle_id}', [RedirectController::class, 'driver_vehicle_edit'])
        ->name('driver.vehicle.edit');

    //Action
    Route::put('/driver/project/delivery/{resource_id}/{action}', [ResourceController::class, 'resource_delivery_update'])
        ->name('driver.delivery.update');

    Route::post('/driver/vehicle/add/', [VehicleController::class, 'driver_add'])
        ->name('driver.vehicle.add');
    
    Route::put('/driver/vehicle/edit/{vehicle_id}', [VehicleController::class, 'driver_edit'])
        ->name('driver.vehicle.edit');
});