@extends("headerPr")
@section("title", "Lista de Artículos")
@section("seccioProva")
    <div class="articles-container">
        <!-- HEADER -->
        <div class="articles-header">
            <h1>Lista de Artículos</h1>
        </div>
        <div class="articles-header">
            <div class="header-controls">
                <form action="{{ request()->url() }}" method="GET" id="searchForm">
                    <div class="search-box">
                        <div class="search-input-container">
                            <span class="search-icon">🔍</span>
                            <input type="text" name="search" placeholder="Buscar artículos..." 
                                value="{{ request('search') }}" id="searchInput">
                            <button type="button" class="clear-search" id="clearSearch" title="Limpiar búsqueda" @if(!request('search')) style="display:none" @endif>×</button>
                        </div>
                    </div>
                    
                    <div class="per-page-selector">
                        <label for="perPage">Mostrar:</label>
                        <select name="perPage" id="perPage">
                            @foreach([1, 5, 10, 15, 25, 50] as $option)
                                <option value="{{ $option }}" {{ $perPage == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="sort-selector">
                        <label for="sort">Ordenar por:</label>
                        <select name="sort" id="sort">
                            <option value="none" {{ request('sort', 'none') == 'none' ? 'selected' : '' }}>Predeterminado</option>
                            <option value="titol_asc" {{ request('sort') == 'titol_asc' ? 'selected' : '' }}>Título (A-Z)</option>
                            <option value="titol_desc" {{ request('sort') == 'titol_desc' ? 'selected' : '' }}>Título (Z-A)</option>
                            <option value="cos_asc" {{ request('sort') == 'cos_asc' ? 'selected' : '' }}>Cuerpo (A-Z)</option>
                            <option value="cos_desc" {{ request('sort') == 'cos_desc' ? 'selected' : '' }}>Cuerpo (Z-A)</option>
                        </select>
                    </div>
                    
                    @if($view === 'user') 
                        <a href="{{ route('articles.create') }}" class="btn-create">Crear Nuevo Artículo</a>
                    @endif
                </form>
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
                            <button class="qr-code-btn btn btn-view" data-article-id="{{ $articulo->ID }}">Ver QR</button>
                        </div>
                </div>
            @endforeach
        </div>
        <div class="pagination-container">
            {{ $articles->links() }}
        </div>
    </div>

    <script src="{{ asset('js/article-filters.js') }}"></script>
@endsection
