@extends("headerPr")
@section("title", "Lista de Artículos")
@section("seccioProva")
    <h1>Lista de Artículos</h1>
    <a href="{{ route('article.create') }}">Crear Nuevo Artículo</a>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <ul>
        @foreach($articles as $articulo)
            <li>
                <strong>{{ $articulo->titol }}</strong> - {{ $articulo->Usuari }}
                <a href="{{ route('articles.show', $articulo->ID) }}">Ver</a>
                <a href="{{ route('articles.edit', $articulo->ID) }}">Editar</a>
                <form action="{{ route('articles.destroy', $articulo->ID) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
