<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RequerimientoController;
use App\Http\Controllers\RequerimientoItemController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\OcController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CatalogoItemController;
use App\Http\Controllers\CentroCostoController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\UsuarioController; // si lo creaste

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
});

// Requerimientos
Route::prefix('requerimientos')->group(function () {
    Route::post('', [RequerimientoController::class, 'crear']);
    Route::put('{id}', [RequerimientoController::class, 'actualizar']);
    Route::post('cambiar-estado', [RequerimientoController::class, 'cambiarEstado']);
    Route::get('{id}', [RequerimientoController::class, 'ver']);
    Route::get('sector/{idSector}', [RequerimientoController::class, 'listarPorSector']);

    // Items
    Route::post('{id}/items', [RequerimientoItemController::class, 'agregar']);
    Route::get('{id}/items', [RequerimientoItemController::class, 'listarPorRequerimiento']);
});

// Items (individual)
Route::prefix('items')->group(function () {
    Route::put('{id}', [RequerimientoItemController::class, 'actualizar']);
    Route::delete('{id}', [RequerimientoItemController::class, 'eliminar']);
});

// Presupuestos
Route::prefix('presupuestos')->group(function () {
    Route::post('', [PresupuestoController::class, 'crear']);
    Route::get('requerimiento/{idReq}', [PresupuestoController::class, 'listarPorRequerimiento']);
});

// OC
//Route::prefix('oc')->group(function () {
  //  Route::post('vincular', [OcController::class, 'vincular']);
//});

// ---- ORDENES DE COMPRA ----
Route::prefix('oc')->group(function () {
    Route::post('crear', [OcController::class, 'crear']);
    Route::get('ver/{id}', [OcController::class, 'ver']);
    Route::post('vincular', [OcController::class, 'vincular']);
});

// Documentos
Route::post('documentos/subir', [DocumentoController::class, 'subir']);

// Proveedores
Route::prefix('proveedores')->group(function () {
    Route::get('', [ProveedorController::class, 'listar']);
    Route::get('activos', [ProveedorController::class, 'listarActivos']);
    Route::post('', [ProveedorController::class, 'crear']);
    Route::get('{id}', [ProveedorController::class, 'ver']);
    Route::put('{id}', [ProveedorController::class, 'actualizar']);
});

// Catalogo Items
Route::prefix('catalogo')->group(function () {
    Route::get('', [CatalogoItemController::class, 'listar']);
    Route::get('activos', [CatalogoItemController::class, 'listarActivos']);
    Route::get('{id}', [CatalogoItemController::class, 'ver']);
    Route::post('', [CatalogoItemController::class, 'crear']);
    Route::put('{id}', [CatalogoItemController::class, 'actualizar']);
    Route::delete('{id}', [CatalogoItemController::class, 'eliminar']);
});

// Centros de Costo
Route::prefix('centros-costo')->group(function () {
    Route::get('', [CentroCostoController::class, 'listar']);
    Route::get('{id}', [CentroCostoController::class, 'ver']);
});

// Sectores
Route::prefix('sectores')->group(function () {
    Route::get('', [SectorController::class, 'listar']);
    Route::get('{id}', [SectorController::class, 'ver']);
    Route::post('', [SectorController::class, 'crear']);
    Route::put('{id}', [SectorController::class, 'actualizar']);
});

// Usuarios
Route::prefix('usuarios')->group(function () {
    Route::get('', [UsuarioController::class, 'listar']);
    Route::get('{id}', [UsuarioController::class, 'ver']);
    Route::post('', [UsuarioController::class, 'crear']);
    Route::put('{id}', [UsuarioController::class, 'actualizar']);
    Route::delete('{id}', [UsuarioController::class, 'eliminar']);
});
