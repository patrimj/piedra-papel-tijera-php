<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartidaController;
use App\Http\Controllers\TiradaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AuthController;


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

Route::post('/login', [AuthController::class, 'login'])->name('login'); //name para el middleware de Authenticate
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/registrarse', [AuthController::class, 'registrarse']);

// CRUD DE USUARIOS SOLO ACCESIBLE PARA ADMINISTRADORES
Route::middleware('rol', 'auth')->group(function () {
    Route::prefix('usuario')->group(function () {
        Route::get('/todos', [UsuarioController::class, 'listaUsuarios']);
        Route::get('/{id}', [UsuarioController::class, 'usuarioID']);
        Route::post('/nuevo', [UsuarioController::class, 'nuevoUsuario']);
        Route::put('/modificar/{id}', [UsuarioController::class, 'modificarUsuario']);
        Route::delete('/eliminar/{id}', [UsuarioController::class, 'eliminarUsuario']);
    });
});

// ELIMINAR PARTIDA SOLO ACCESIBLE PARA ADMINISTRADORES
Route::middleware('rol', 'auth')->group(function () {
    Route::prefix('partida')->group(function () {
        Route::delete('/eliminar/{id}', [PartidaController::class, 'eliminarPartida']);
    });
});

//ACCESIBLE PARA TODOS LOS USUARIOS QUE NO SEAN ADMINISTRADORES
Route::middleware('rol', 'auth')->group(function () {
    Route::prefix('partida')->group(function () {
        Route::post('/crear', [PartidaController::class, 'crearPartida']) ->middleware ('VerificarPartida');

        Route::get('/todas', [PartidaController::class, 'listaPartidas']);
        Route::get('/{id}', [PartidaController::class, 'partidaID']);
        Route::get('/resultado/{id}', [PartidaController::class, 'obtenerResultado']);
        Route::put('/finalizar/{id}', [PartidaController::class, 'finalizarPartida']);
        Route::post('/jugar', [PartidaController::class, 'jugar']);
        
        
    });
});

Route::middleware('inicio')->group(function () {
    Route::prefix('usuario')->group(function () {
        Route::get('/informacion{id}', [UsuarioController::class, 'usuarioID']);
        
    });
});

Route::middleware('inicio')->group(function () {
    Route::prefix('tirada')->group(function () {
        Route::get('/todas', [TiradaController::class, 'listaTiradas']);
        Route::get('/{id}', [TiradaController::class, 'tiradaID']);
        Route::post('/tirada', [TiradaController::class, 'realizarTirada']);
    });
});

Route::get('ranking', [PartidaController::class, 'ranking']);




