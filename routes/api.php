<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas de API para services
Route::prefix('/services')->group(function () {
    // Listado
    Route::get('/', [\App\Http\Controllers\ServiceController::class, 'getAll']);
    // Detalle
    Route::get('/{id}', [\App\Http\Controllers\ServiceController::class, 'get']);
    // Crear
    Route::post('/', [\App\Http\Controllers\ServiceController::class, 'create']);
    // Modificar
    Route::put('/', [\App\Http\Controllers\ServiceController::class, 'update']);
    // Borrar
    Route::delete('/{id}', [\App\Http\Controllers\ServiceController::class, 'delete']);
});
