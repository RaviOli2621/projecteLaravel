@extends("headerPr")
@section("title", "Lista de Artículos")
@section("seccioProva")
    <div class="articles-container">
        <div class="articles-header">
            <h1>Lista de Artículos</h1>
            @if($view === 'user') 
                <a href="{{ route('articles.create') }}" class="btn-create">Crear Nuevo Artículo</a>
            @endif
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
@endsection
