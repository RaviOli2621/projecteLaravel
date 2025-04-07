<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
 
class ArticleController extends Controller
{
    // Obtener todos los artículos
    public function index()
    {
        $articles = Article::getAll();
        return view('articles.pagination', ['articles' => $articles, "view" => "index"]);
    }
    public function userArticles(){
        $userCorreu = Auth::user()->Correu;
        $articles = Article::getByUserCorreu($userCorreu);
        return view('articles.pagination', ['articles' => $articles, "view" => "user"]);
    }

    // Obtener un artículo por ID
    public function show($id)
    {
        $article = Article::getById($id);
        if ($article) {
            return view('articles.show', ['article' => $article]);
        }
        return response()->json(['message' => 'Article not found'], 404);
    }

    // Mostrar el formulario para crear un nuevo artículo
    public function create()
    {
        return view('articles.create');
    }

    // Crear un nuevo artículo
    public function store(Request $request)
    {
        $userCorreu = Auth::user()->Correu;

        $data = $request->validate([
            'titol' => 'required|string|max:255',
            'cos' => 'required|string',
            'copyTitol' => 'nullable|boolean',
            'copyCos' => 'nullable|boolean',
        ]);
        $data['Usuari'] = $userCorreu;

        $data['qr'] = '';
        if ($request->input('copyTitol')) {
            $data['qr'] .= $data['titol'];
        }
        if ($request->input('copyCos')) {
            $data['qr'] .= '|' . $data['cos'];
        }
        unset($data['copyTitol']);
        unset($data['copyCos']);
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
