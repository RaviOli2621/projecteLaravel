<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
 
class ArticleController extends Controller
{
    // Obtener todos los artículos
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', session('perPage', 10));
        session(['perPage' => $perPage]); 
        
        $articles = Article::getAll($perPage);
        return view('articles.pagination', [
            'articles' => $articles, 
            "view" => "index",
            'perPage' => $perPage
        ]);
    }
    
    public function userArticles(Request $request){
        $perPage = $request->input('perPage', session('perPage', 10));
        session(['perPage' => $perPage]); 
        
        $userCorreu = Auth::user()->Correu;
        $articles = Article::getByUserCorreu($userCorreu, $perPage);
        return view('articles.pagination', [
            'articles' => $articles, 
            "view" => "user",
            'perPage' => $perPage
        ]);
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
        return view('articles.show', ['article' => $article]);
    }
    public function edit($id)
    {
        $article = Article::getById($id);
        
        if (!$article) {
            return redirect()->route('articles.index')
                ->with('error', 'Artículo no encontrado');
        }
        
        // Verificar si el usuario es el propietario del artículo
        if (Auth::user()->Correu !== $article->Usuari) {
            return redirect()->route('articles.index')
                ->with('error', 'No tienes permiso para editar este artículo');
        }
        
        return view('articles.edit', ['article' => $article]);
    }
    // Actualizar el título de un artículo
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'titol' => 'required|string|max:255',
            'cos' => 'required|string|max:255',
            'qr' => ['nullable', 'regex:/^(true|false)\|(true|false)$/'],
        ]);
        // Get the article first to check ownership
        $article = Article::getById($id);
        if (!$article) {
            return response()->json(['message' => 'Article not found'], 404);
        }

        // Verify the current user is the owner of the article
        if (Auth::user()->Correu !== $article->Usuari) {
            return redirect()->route('articles.index')
                ->with('error', 'No tienes permiso para modificar este artículo');
        }
        $data["usuari"] = $article->Usuari;
        $article = Article::updateArticulo($id, $data);
        if ($article) {
            return view('articles.show', ['article' => $article]);
        }
        return response()->json(['message' => 'Article not found'], 404);
    }

    // Eliminar un artículo por ID
    public function destroy($id)
    {
        $deleted = Article::deleteById($id);
        if ($deleted) {
            return redirect()->route('articles.index')
                ->with('success', 'Artículo eliminado correctamente');
        }
        return response()->json(['message' => 'Article not found'], 404);
    }

    
}
