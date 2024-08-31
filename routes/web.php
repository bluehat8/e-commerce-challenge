<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/products', function () {
        return view('dashboard');
    })->name('products.index');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/create-products', [ProductController::class, 'create'])->name('products.create');
    Route::post('/store-products', [ProductController::class, 'store'])->name('products.store');

    Route::get('/informes', [SalesController::class, 'generar'])->name('informes.mostrar');


    //Client

    Route::get('/product-list', [ProductController::class, 'client_index'])->name('pruducts.client');
    Route::get('/product/{id}/purchase', [SalesController::class, 'showPurchaseForm'])->name('purchase.form');
    Route::post('/ventas/comprar/{id}', [SalesController::class, 'comprar'])->name('ventas.comprar');

});



// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//     // Otras rutas exclusivas para administradores
// });

// Route::middleware(['auth', 'role:cliente'])->group(function () {
//     Route::get('/cliente/dashboard', [ClienteController::class, 'dashboard'])->name('cliente.dashboard');
//     // Otras rutas exclusivas para clientes
// });

// Route::middleware(['auth', 'role:admin,cliente'])->group(function () {
//     // Rutas accesibles tanto para administradores como para clientes
// });
