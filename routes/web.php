<?php

use App\Models\Item;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;

Route::middleware(['auth','admin'])->group(function(){
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin');
    Route::get('/admin/inventory', function () {
        $items = Item::get();
        return view('admin.inventory', compact('items'));
    })->name('admin.inventory');

    Route::get('/admin/user-management', function () {
        $userlist = Item::get();
        return view('admin.user-management', compact('userlist'));
    })->name('admin.user-management');
});

//Site
Route::middleware('auth')->group(function(){
    Route::get('/', function () {
        return view('home');
    })->name('/')->middleware('auth');

    Route::get('/new', function(){
        return view('new');
    })->name('new');
    
});

//User-account
Route::get('/login', function () {
    return view('auth/login'); 
})->name('login');
Route::get('/register', function () {
    return view('auth/register'); 
})->name(name: 'register');

Route::post('/login', [UserController::class, 'login'] )
->middleware('throttle:5,1');
Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout'] );

//Items
Route::middleware(['auth','admin'])->group(function () {
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');

    Route::get('/items/{id}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{id}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');
});
