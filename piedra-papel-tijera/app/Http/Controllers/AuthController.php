<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login (Request $request) {

        try{
            $validator = Validator::make($request->all(), [ // validacion de los campos
                'email' => 'required|string|email|max:55',
                'contraseña' => 'required|string|min:8',
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }else{
                $usuario = Usuario::where('email', $request->email)->first(); // buscar usuario por email
            }
    
            if (!$usuario || !Hash::check($request->contraseña, $usuario->contraseña)) { 
                return response()->json([
                    'message' => 'datos incorrectos'
                ], 401);
            }else{
                $token = $usuario->createToken('authToken')->plainTextToken;
    
                return response()->json([
                    'usuario' => $usuario,
                    'token' => $token
                ], 200);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error en el servidor',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function logout (Request $request) {
        try {
            $auth = Auth::user();
        
            $nombre = $auth->nombre; // ejemplo de como seria util usar -> $auth = Auth::user(); para acceder a los datos del usuario que ha iniciado sesion
        
            $request->user()->currentAccessToken()->delete();
        
            return response()->json([
                'message' => 'sesion cerrada',
                'nombre' => $nombre
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error en el servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function registrarse (Request $request) {

        try{

            $message = [
                'nombre.required' => 'El campo nombre es obligatorio',
                'email.required' => 'El campo email es obligatorio',
                'contraseña.required' => 'El campo contraseña es obligatorio',
                'email' => 'El campo :email debe ser un email',
                'max' => 'El campo :nombre debe tener como máximo :max caracteres',
                'min' => 'El campo :contraseña debe tener como mínimo :min caracteres',
                'unique' => 'El campo :email ya existe',
                'confirmed' => 'El campo :contraseña debe ser igual al campo de confirmación',

            ];
            $validator = Validator::make($request->all(), [ // validacion de los campos
                'nombre' => 'required|string|max:55',
                'email' => 'required|string|email|max:55|unique:usuarios',
                'contraseña' => 'required|string|min:8|confirmed',
        
            ],$message);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }else{
                $usuario = new Usuario();
                $usuario->nombre = $request->nombre;
                $usuario->email = $request->email;
                $usuario->contraseña = Hash::make($request->contraseña);
                $usuario->rol = $request->rol;
                $usuario->save();
    
                return response()->json([
                    'usuario' => $usuario,
                    'message' => 'usuario creado'
                ], 201);
            }

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error en el servidor',
                'error' => $e->getMessage()
            ], 500);
        }

    }

    /*
    TEORÍA VALIDATOR 
    - 'required' => es obligatorio => 'email' => 'required'
    - 'string' => debe ser un string => 'email' => 'string'
    - 'email' => debe ser un email => 'email' => 'email'
    - 'max:55' => longitud máxima de 55 caracteres => 'email' => 'max:55'
    - 'min:8' => longitud mínima de 8 caracteres => 'contraseña' => 'min:8'
    - 'unique' => debe ser único en la tabla => 'email' => 'unique'
    - 'confirmed' => debe ser igual al campo de confirmación => 'contraseña' => 'confirmed'
    - 'exists:usuarios,id' => debe existir en la tabla usuarios, en el campo id => 'id' => 'exists:usuarios,id'
    - 'exists:usuarios,id,rol,admin' => debe existir en la tabla usuarios, en el campo id, y el campo rol debe ser igual a admin => 'id' => 'exists:usuarios,id,rol,admin'
    - 'birthdate' => debe ser una fecha válida => 'birthdate' => 'birthdate'
    - integer => debe ser un número entero => 'id' => 'integer'
    - 'numeric' => debe ser un número   => 'id' => 'numeric'
    - 'digits_between:1,3' => debe tener entre 1 y 3 dígitos => 'id' => 'digits_between:1,3'
    - 'digits:3' => debe tener 3 dígitos => 'id' => 'digits:3'
    - 'date_format:Y-m-d' => debe tener el formato de fecha Y-m-d => 'birthdate' => 'date_format:Y-m-d'
    - 'regex' => debe cumplir una expresión regular => 'email' => 'regex:/^.+@.+$/i'
    */
    
}
