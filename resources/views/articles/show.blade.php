@extends("headerPr")

@section("title", "Ver Artículo")

@section("seccioProva")
    <h1>{{ $articulo->titol }}</h1>
    <p><strong>Usuario:</strong> {{ $articulo->Usuari }}</p>
    <p><strong>Cuerpo:</strong> {{ $articulo->cos }}</p>
    <p><strong>QR:</strong> {{ $articulo->qr }}</p>

    <a href="{{ route('articulos.index') }}">Volver a la lista</a>
@endsection
