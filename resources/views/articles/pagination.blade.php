@extends("headerPr")
@section("title", "Lista de Artículos")
@section("seccioProva")
    <div class="articles-container">
        <div class="articles-header">
            <h1>Lista de Artículos</h1>
            <div class="header-controls">
                <div class="per-page-selector">
                    <form action="{{ request()->url() }}" method="GET">
                        <label for="perPage">Mostrar:</label>
                        <select name="perPage" id="perPage" onchange="this.form.submit()">
                            @foreach([5, 10, 15, 25, 50] as $option)
                                <option value="{{ $option }}" {{ $perPage == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                @if($view === 'user') 
                    <a href="{{ route('articles.create') }}" class="btn-create">Crear Nuevo Artículo</a>
                @endif
            </div>
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
        <div class="pagination-container">
            {{ $articles->links() }}
        </div>
    </div>

    <style>
        .header-controls {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .per-page-selector {
            display: flex;
            align-items: center;
        }
        
        .per-page-selector label {
            margin-right: 8px;
            font-size: 0.9rem;
            color: #666;
        }
        
        .per-page-selector select {
            padding: 5px 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            background-color: white;
            cursor: pointer;
            font-size: 0.9rem;
        }
    </style>
@endsection
