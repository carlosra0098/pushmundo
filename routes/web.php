<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\FacturasController;

// Ruta raíz - Redirigir a clientes
Route::get('/', function () {
    return redirect()->route('clientes.index');
});

Auth::routes();

// Rutas para gestión de clientes (públicas)
Route::resource('clientes', ClientesController::class);
Route::get('clientes-eliminados', [ClientesController::class, 'eliminados'])->name('clientes.eliminados');
Route::post('clientes/{id}/restaurar', [ClientesController::class, 'restaurar'])->name('clientes.restaurar');
Route::delete('clientes/{id}/forzar-eliminar', [ClientesController::class, 'forzarEliminar'])->name('clientes.forzar-eliminar');

// Recursos CRM
Route::resource('productos', ProductosController::class);
Route::get('productos-eliminados', [ProductosController::class, 'eliminados'])->name('productos.eliminados');
Route::post('productos/{id}/restaurar', [ProductosController::class, 'restaurar'])->name('productos.restaurar');
Route::delete('productos/{id}/forzar-eliminar', [ProductosController::class, 'forzarEliminar'])->name('productos.forzar-eliminar');

Route::resource('proveedores', ProveedoresController::class);
Route::get('proveedores-eliminados', [ProveedoresController::class, 'eliminados'])->name('proveedores.eliminados');
Route::post('proveedores/{id}/restaurar', [ProveedoresController::class, 'restaurar'])->name('proveedores.restaurar');
Route::delete('proveedores/{id}/forzar-eliminar', [ProveedoresController::class, 'forzarEliminar'])->name('proveedores.forzar-eliminar');

Route::resource('empleados', EmpleadosController::class);
Route::get('empleados-eliminados', [EmpleadosController::class, 'eliminados'])->name('empleados.eliminados');
Route::post('empleados/{id}/restaurar', [EmpleadosController::class, 'restaurar'])->name('empleados.restaurar');
Route::delete('empleados/{id}/forzar-eliminar', [EmpleadosController::class, 'forzarEliminar'])->name('empleados.forzar-eliminar');

Route::resource('facturas', FacturasController::class);
Route::get('facturas-eliminados', [FacturasController::class, 'eliminados'])->name('facturas.eliminados');
Route::post('facturas/{id}/restaurar', [FacturasController::class, 'restaurar'])->name('facturas.restaurar');
Route::delete('facturas/{id}/forzar-eliminar', [FacturasController::class, 'forzarEliminar'])->name('facturas.forzar-eliminar');

// Perfil de usuario
Route::get('profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile')->middleware('auth');
Route::get('profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::patch('profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::post('profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password')->middleware('auth');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

