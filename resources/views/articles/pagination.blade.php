@extends("headerPr")
@section("title", "Lista de Artículos")
@section("seccioProva")
    <div class="articles-container">
        <div class="articles-header">
            <h1>Lista de Artículos</h1>
            <a href="{{ route('articles.create') }}" class="btn-create">Crear Nuevo Artículo</a>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="articles-list">
            @foreach($articles as $articulo)
                <div class="article-card">
                    <div class="article-content">
                        <h2 class="article-title">{{ $articulo->titol }}</h2>
                        <p class="article-body">{{ Str::limit($articulo->cos, 100) }}</p>
                        <p class="article-author">Autor: {{ $articulo->Usuari }}</p>
                    </div>
                        <div class="article-actions">
                            <a href="{{ route('articles.show', $articulo->ID) }}" class="btn btn-view">Ver</a>
                            
                            @if($view === 'user')
                                <a href="{{ route('articles.edit', $articulo->ID) }}" class="btn btn-edit">Editar</a>
                                <form action="{{ route('articles.destroy', $articulo->ID) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">Eliminar</button>
                                </form>
                            @endif
                        </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .articles-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .articles-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .btn-create {
            background-color: var(--green-color);
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        
        .btn-create:hover {
            background-color: var(--dark-color);
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .articles-list {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .article-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
        }
        
        .article-content {
            flex-grow: 1;
        }
        
        .article-title {
            margin-top: 0;
            color: var(--dark-color);
            font-size: 1.4rem;
        }
        
        .article-body {
            color: #666;
            margin-bottom: 15px;
        }
        
        .article-author {
            font-size: 0.9rem;
            color: #888;
            font-style: italic;
        }
        
        .article-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 8px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .btn-view {
            background-color: #e7f3ff;
            color: #0366d6;
        }
    </style>
@endsection
