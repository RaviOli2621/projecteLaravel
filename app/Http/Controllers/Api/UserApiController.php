<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserApiController extends Controller
{
    /**
     * Devuelve todos los usuarios (solo para administradores)
     * La verificación de admin ya la hace el middleware
     */
    public function users(Request $request)
    {
        // El middleware ya ha verificado que el usuario es admin
        return response()->json(User::all());
    }
}