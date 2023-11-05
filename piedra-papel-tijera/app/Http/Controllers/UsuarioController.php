<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller{

    //funcion inicio de sesión

    public function login(Request $request)
    {
        try {
            $id = $request->get('id');
            $contrasena = $request->get('contraseña');
    
            // Busca al usuario por nombre
            $usuario = Usuario::where('id', $id)->first();
    
            // Verifica si el usuario existe y la contraseña coincide usando Hash::check
            if ($usuario && Hash::check($contrasena, $usuario->contraseña)) {
                return $usuario;
            
            } else {
                return response()->json(['error' => 'Usuario o contraseña incorrectos'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al iniciar sesión'], 500);
        }
    }
    

    public function listaUsuarios(){  // todos los usuarios
        try {
            $usuarios = Usuario::all();
            return $usuarios;

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener la lista de usuarios'], 500);
        }
    }

    public function usuarioID(Request $request){ // usuario por id
        try{
            $id = $request->get('id');

            $usuario = Usuario::find($id);
            return $usuario;

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el usuario'], 500);
        }    

    }

    public function nuevoUsuario(Request $request){ //se crea un nuevo usuario
        
        try{
            $usuario = new Usuario();
            $usuario->nombre = $request->get('nombre');
            $usuario->contraseña = $request->get('contraseña');
            $usuario->partidas_jugadas = $request->get('partidas_jugadas');
            $usuario->partidas_ganadas = $request->get('partidas_ganadas');
            $usuario->rol = $request->get('rol');

            $usuario->save();
            return $usuario;

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear el usuario'], 500);
        }
    }

    public function modificarUsuario(Request $request){ //se modifica un usuario
        try{
            $usuario = Usuario::find($request->get('id'));

            $usuario->nombre = $request->get('nombre');
            $usuario->contraseña = $request->get('contraseña');
            $usuario->partidas_jugadas = $request->get('partidas_jugadas');
            $usuario->partidas_ganadas = $request->get('partidas_ganadas');
            $usuario->rol = $request->get('rol');

            $usuario->save();
            return $usuario;

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al modificar el usuario'], 500);
        }
    }

    public function eliminarUsuario(Request $request){ //elimina un usuario
        try{
            $usuario = Usuario::find($request->get('id'));

            $usuario->delete();
            return $usuario;

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el usuario'], 500);
        }
    }

}