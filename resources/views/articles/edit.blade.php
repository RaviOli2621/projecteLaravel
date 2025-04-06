@extends("headerPr")

@section("title", "Editar Artículo")

@section("seccioProva")
    <h1>Editar Artículo</h1>
    <form action="{{ route('articulos.update', $articulo->ID) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Usuario:</label>
        <input type="text" name="Usuari" value="{{ $articulo->Usuari }}" required>

        <label>Título:</label>
        <input type="text" name="titol" value="{{ $articulo->titol }}" required>

        <label>Cuerpo:</label>
        <textarea name="cos" required>{{ $articulo->cos }}</textarea>

        <label>QR (Opcional):</label>
        <input type="text" name="qr" value="{{ $articulo->qr }}">

        <button type="submit">Actualizar</button>
    </form>
@endsection
