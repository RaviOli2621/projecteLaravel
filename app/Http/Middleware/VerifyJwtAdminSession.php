<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class VerifyJwtAdminSession
{
    /**
     * Verifica que el usuario tenga un token JWT en la sesión y sea administrador
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // Obtener el token JWT de la sesión
            $token = session('jwt_token');
            
            if (!$token) {
                return response()->json(['error' => 'Token no encontrado en la sesión'], 401);
            }
            
            // Verificar el token
            JWTAuth::setToken($token);
            $payload = JWTAuth::getPayload();
            
            // Comprobar si el usuario es admin según el claim del JWT
            if (!$payload->get('is_admin')) {
                return response()->json(['error' => 'No autorizado. Acceso solo para administradores'], 403);
            }
            
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token inválido o expirado'], 401);
        }
        
        return $next($request);
    }
}