<?php

use App\Models\Item;
use App\Models\User;
use App\Models\Projects;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectItemController;

// ADMIN
Route::middleware(['auth','admin'])->group(function(){
    // Redirect
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin');
    Route::get('/admin/inventory', function () {
        $items = Item::get();
        return view('admin.inventory', compact('items'));
    })->name('admin.inventory');

    Route::get('/admin/users', function () {
        $users = User::get();
        return view('admin.users', compact('users'));
    })->name('admin.users');

    // User Changes
    Route::put('/users/{id}', [UserController::class, 'changeRole'])->name('users.updateRole');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Items
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{id}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{id}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');
});

// SITE
Route::middleware('auth')->group(function(){
    // Redirect
    Route::get('/', function () {
        $projects = Projects::get();
        return view('home', compact('projects'));
    })->name('/');
    Route::get('/project/{project}', [ProjectController::class, 'view'])->name('project.view');
    Route::post('/project/new', [ProjectController::class, 'new'])->name('project.new');

    //Project Items
    Route::post('/project/item/store', [ProjectItemController::class, 'store'])->name('project_items.store');
});

//User-account
Route::get('/login', function () {
    return view('auth/login'); 
})->name('login');
Route::get('/register', function () {
    return view('auth/register'); 
})->name(name: 'register');

Route::post('/login', [UserController::class, 'login'] )
->middleware('throttle:5,1')->name('login');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/logout', [UserController::class, 'logout'] )->name('logout');