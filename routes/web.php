<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineTypeController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\SupplierController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Medicine Types Management
        Route::resource('medicine-types', MedicineTypeController::class);

        // Medicines Management
        Route::resource('medicines', MedicineController::class);
        // Inventory/Batches
        Route::resource('inventory-batches', App\Http\Controllers\InventoryBatchController::class);
        Route::post('inventory-batches/{inventory_batch}/adjust', [App\Http\Controllers\InventoryBatchController::class, 'adjust'])->name('inventory-batches.adjust');
        
    // Stock Movements
    Route::resource('stock-movements', App\Http\Controllers\StockMovementController::class)->only(['index','show']);

    // Suppliers
    Route::resource('suppliers', SupplierController::class);

    // Purchases
    Route::resource('purchases', App\Http\Controllers\PurchaseController::class);
    // Purchase Items
    Route::resource('purchase-items', App\Http\Controllers\PurchaseItemController::class)->only(['index','show']);

    // Sales
    Route::resource('sales', App\Http\Controllers\SaleController::class);
    // Sale Items
    Route::resource('sale-items', App\Http\Controllers\SaleItemController::class)->only(['index','show']);
});

require __DIR__.'/auth.php';

// API-like helper for typeahead (simple, authenticated)
Route::get('/api/medicines/search', [App\Http\Controllers\MedicineController::class, 'search'])->middleware('auth')->name('api.medicines.search');
