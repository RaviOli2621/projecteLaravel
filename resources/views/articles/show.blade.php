@extends("headerPr")

@section("title", "Ver Artículo")

@section("seccioProva")
    <h1>{{ $article->titol }}</h1>
    <p><strong>Usuario:</strong> {{ $article->Usuari }}</p>
    <p><strong>Cuerpo:</strong> {{ $article->cos }}</p>
    <p><strong>QR:</strong> {{ $article->qr }}</p>

    <a href="{{ route('articles.index') }}">Volver a la lista</a>
@endsection
