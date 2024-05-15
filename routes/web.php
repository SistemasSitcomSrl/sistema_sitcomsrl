<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AssetAllocationController;
use App\Http\Controllers\WorkersController;
use App\Http\Controllers\TransfersInventoriesController;
use App\Http\Controllers\TransferRequiredController;
use App\Http\Controllers\TransferController;

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::resource('/', HomeController::class)->names('admin.home');
    Route::resource('/usuarios', UserController::class)->names('admin.users');

    Route::resource('/proyecto', ProjectController::class)->names('admin.projecto');

    Route::resource('/sucursal', BranchController::class)->names('admin.branch');

    //Inventario de herramientas o activos
    Route::get('/inventario', [InventoryController::class, 'index'])->name('admin.inventory.index');
    Route::get('/inventario_activo', [InventoryController::class, 'index_activo'])->name('admin.inventory_asset.index');
    Route::post('/inventario/descargar', [InventoryController::class, 'download'])->name('admin.inventory.download');

    //Solicitud agregar herramientas o activos
    Route::get('/solicitud', [TransfersInventoriesController::class, 'index'])->name('admin.request.index');
    Route::get('/solicitud_activo', [TransfersInventoriesController::class, 'index_activo'])->name('admin.request_asset.index');
    Route::get('/solicitud/crear', [TransfersInventoriesController::class, 'create'])->name('admin.request.create');
    Route::post('/solicitud/descargar', [TransfersInventoriesController::class, 'download'])->name('downloadResquestCreate');

    //Solicitud de Dar de Baja herramientas o activos
    Route::get('/retirado', [TransferRequiredController::class, 'index'])->name('admin.retired.index');
    Route::get('/retirado_activo', [TransferRequiredController::class, 'index_activo'])->name('admin.retired_asset.index');
    Route::get('/retirado/crear', [TransferRequiredController::class, 'create'])->name('admin.retired.create');
    Route::post('/retirado/descargar', [TransferRequiredController::class, 'download'])->name('admin.retired.download');

    //Transferencia Enviadas de herramientas a otras sucursales  
    Route::get('/enviadas', [TransferController::class, 'index'])->name('admin.transfer-sent.index');
    Route::get('/enviadas/Crear', [TransferController::class, 'create'])->name('admin.transfer-sent.create');
    Route::post('/enviadas/descargar', [TransferController::class, 'download'])->name('admin.transfer-sent.download');
    
    //Transferencia Recibidas de herramientas a otras sucursales  
    Route::get('/recibidas', [TransferController::class, 'index_received'])->name('admin.transfer-received.index');
    Route::post('/recibidas/descargar', [TransferController::class, 'download'])->name('admin.transfer-received.download');

    //Movimientos de herramientas
    Route::get('/prestar', [MovementController::class, 'index'])->name('admin.movement.index');
    Route::get('/prestar/crear', [MovementController::class, 'create'])->name('admin.movement.create');
    Route::post('/prestar/descargar', [MovementController::class, 'download'])->name('admin.movement.download');

    //Trabajadores
    Route::resource('/trabajadores', WorkersController::class)->names('admin.workers');

    //Asignar herramientas a trabajadores
    Route::get('/asignar', [AssetAllocationController::class, 'index'])->name('admin.assign.index');
    Route::get('/asignar/crear', [AssetAllocationController::class, 'create'])->name('admin.assign.create');
    Route::post('/asignar/pdf', [AssetAllocationController::class, 'pdf'])->name('admin.assign.pdf');

    

    Route::resource('/roles', RoleController::class)->names('admin.roles');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


});

require __DIR__ . '/auth.php';
