<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    // Obtener todos los artículos
    public function index()
    {
        $articles = Article::getAll();
        return view('articles.pagination', ['articles' => $articles]);
    }

    // Obtener un artículo por ID
    public function show($id)
    {
        $article = Article::getById($id);
        if ($article) {
            return response()->json($article);
        }
        return response()->json(['message' => 'Article not found'], 404);
    }

    // Crear un nuevo artículo
    public function store(Request $request)
    {
        $data = $request->validate([
            'Usuari' => 'required|integer',
            'titol' => 'required|string|max:255',
            'cos' => 'required|string',
            'qr' => 'nullable|string',
        ]);

        $article = Article::createArticulo($data);
        return response()->json($article, 201);
    }

    // Actualizar el título de un artículo
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'titol' => 'required|string|max:255',
        ]);

        $article = Article::updateTitulo($id, $data['titol']);
        if ($article) {
            return response()->json($article);
        }
        return response()->json(['message' => 'Article not found'], 404);
    }

    // Eliminar un artículo por ID
    public function destroy($id)
    {
        $deleted = Article::deleteById($id);
        if ($deleted) {
            return response()->json(['message' => 'Article deleted successfully']);
        }
        return response()->json(['message' => 'Article not found'], 404);
    }
}
