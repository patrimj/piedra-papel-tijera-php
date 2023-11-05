<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartidaController;
use App\Http\Controllers\TiradaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Middleware\inicio;
use App\Http\Middleware\rol;
use App\Models\Partida;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//ruta de inicio de sesión
Route::post('login', [UsuarioController::class, 'login']);

// CRUD DE USUARIOS SOLO ACCESIBLE PARA ADMINISTRADORES
Route::prefix('usuario')->group(function () {
    Route::get('todos', [UsuarioController::class, 'listaUsuarios']);
    Route::get('usuario/{id}', [UsuarioController::class, 'usuarioID']);
    Route::post('nuevo', [UsuarioController::class, 'nuevoUsuario']);
    Route::put('modificar/{id}', [UsuarioController::class, 'modificarUsuario']);
    Route::delete('eliminar/{id}', [UsuarioController::class, 'eliminarUsuario']);
})->middleware('rol');


Route::prefix('partida')->group(function () {
    Route::delete('eliminar/{id}', [PartidaController::class, 'eliminarPartida']);
})-> middleware('rol');

//ACCESIBLE PARA TODOS LOS USUARIOS QUE NO SEAN ADMINISTRADORES
Route::prefix('partida')->group(function () {
    Route::post('crear', [PartidaController::class, 'crearPartida']);
    Route::get('resultado/{id}', [PartidaController::class, 'obtenerResultado']);
    Route::get('informacion{id}', [UsuarioController::class, 'usuarioID']);
    Route::post('jugar', [PartidaController::class, 'jugar']);
    Route::post('tirada', [TiradaController::class, 'realizarTirada']);
    Route::get('ranking', [PartidaController::class, 'ranking']);
})->middleware('inicio');



