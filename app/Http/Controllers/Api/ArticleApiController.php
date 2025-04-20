<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleApiController extends Controller
{
    /**
     * Aplica filtros y ordenación a los artículos
     */
    private function applyFiltersAndOrder(Request $request)
    {
        $query = Article::query();
        
        // Filtrar por título si se proporciona el parámetro t
        if ($request->has('t')) {
            $query->where('titol', 'LIKE', '%' . $request->t . '%');
        }
        
        // Filtrar por cuerpo si se proporciona el parámetro b
        if ($request->has('b')) {
            $query->where('cos', 'LIKE', '%' . $request->b . '%');
        }
        
        // Aplicar ordenación
        if ($request->has('order')) {
            switch ($request->order) {
                case 'titol^':
                    $query->orderBy('titol', 'asc');
                    break;
                case 'titol':
                    $query->orderBy('titol', 'desc');
                    break;
                case 'cos^':
                    $query->orderBy('cos', 'asc');
                    break;
                case 'cos':
                    $query->orderBy('cos', 'desc');
                    break;
            }
        } else {
            $query->orderBy('id', 'desc');
        }
        
        return $query;
    }
    
    /**
     * Devuelve todos los artículos
     */
    public function all(Request $request)
    {
        $query = $this->applyFiltersAndOrder($request);
        return response()->json($query->get());
    }
    
    /**
     * Devuelve solo los títulos de los artículos
     */
    public function titol(Request $request)
    {
        $query = $this->applyFiltersAndOrder($request);
        return response()->json($query->get(['id', 'titol']));
    }
    
    /**
     * Devuelve solo los cuerpos de los artículos
     */
    public function body(Request $request)
    {
        $query = $this->applyFiltersAndOrder($request);
        return response()->json($query->get(['id', 'cos']));
    }
}