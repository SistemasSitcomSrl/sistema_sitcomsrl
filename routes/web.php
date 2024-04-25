<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
  
    Route::resource('/',HomeController::class)->names('admin.home');
    Route::resource('/usuarios',UserController::class)->names('admin.users');

    Route::resource('/proyecto',ProjectController::class)->names('admin.projecto');

    Route::resource('/sucursal',BranchController::class)->names('admin.branch');

    Route::resource('/inventario',InventoryController::class)->names('admin.inventory'); 
    Route::get('/solicitud',[InventoryController::class, 'requestInventory'])->name('requestInventory');
    Route::post('/solicitud_herramientas', [InventoryController::class, 'downloadInventory'])->name('downloadInventory');
    Route::post('/solicitud_incorporar', [InventoryController::class, 'downloadResquestCreate'])->name('downloadResquestCreate');

    Route::get('/retirado',[InventoryController::class, 'retiredInventory'])->name('retiredInventory');
    Route::get('/retirado/crear',[InventoryController::class, 'createRetired'])->name('createRetired');     
    Route::post('/anular_herramientas', [InventoryController::class, 'downloadInventoryRetired'])->name('downloadInventoryRetired');

    Route::get('/enviado',[InventoryController::class, 'transferSent'])->name('transfer-sent');
    Route::get('/recibido',[InventoryController::class, 'transferReceived'])->name('transfer');    
    Route::get('/transferencia/Crear',[InventoryController::class, 'createTransfer'])->name('createTransfer');
    Route::post('/transferencia_sucursal', [InventoryController::class, 'downloadTransferSent'])->name('downloadTransferSent');
    
    Route::resource('/movimiento',MovementController::class)->names('admin.movement');
    Route::post('/prestamos_herramientas', [MovementController::class, 'download'])->name('download');

    

    Route::resource('/roles',RoleController::class)->names('admin.roles');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');    
});

require __DIR__.'/auth.php';
