<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller{

    public function listaUsuarios(){  // todos los usuarios
        try {
            $usuarios = Usuario::all();
            return response()->json($usuarios,200); 

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener la lista de usuarios'], 500);
        }
    }

    public function usuarioID(Request $request){ // usuario por id

        try{
            $id = $request->get('id');

            $usuario = Usuario::find($id);

            if (!$usuario) {
                return response()->json(['error' => 'El usuario no existe'], 404);
            }else{
                return response()->json($usuario,200);
            }
       

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener el usuario'], 500);
        }    

    }

    public function nuevoUsuario(Request $request){ //se crea un nuevo usuario
        
        try{
            $usuario = new Usuario();
            $usuario->nombre = $request->get('nombre');
            $usuario->email = $request->get('email');
            $usuario->contraseña = $request->get('contraseña');
            $usuario->partidas_jugadas = $request->get('partidas_jugadas');
            $usuario->partidas_ganadas = $request->get('partidas_ganadas');
            $usuario->rol = $request->get('rol');

            $usuario->save();
            return response()->json($usuario,200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear el usuario'], 500);
        }
    }

    public function modificarUsuario(Request $request){ //se modifica un usuario
        try{
            $usuario = Usuario::find($request->get('id'));

            $usuario->nombre = $request->get('nombre');
            $usuario->email = $request->get('email');
            $usuario->contraseña = $request->get('contraseña');
            $usuario->partidas_jugadas = $request->get('partidas_jugadas');
            $usuario->partidas_ganadas = $request->get('partidas_ganadas');
            $usuario->rol = $request->get('rol');

            $usuario->save();
            return response()->json($usuario,200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al modificar el usuario'], 500);
        }
    }

    public function eliminarUsuario(Request $request){ //elimina un usuario
        try{
            $usuario = Usuario::find($request->get('id'));

            if (!$usuario) {
                return response()->json(['error' => 'El usuario no existe'], 404);
            }else{
                $usuario->delete();
                return response()->json ('Usuario eliminado', 200);
            
            }


        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el usuario'], 500);
        }
    }

}