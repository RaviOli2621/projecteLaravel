@extends("headerPr")

@section("title", "Editar Artículo")

@section("seccioProva")
    <h1>Editar Artículo</h1>
    <form action="{{ route('articles.update', $article->ID) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Título:</label>
        <input type="text" name="titol" value="{{ $article->titol }}" required>

        <label>Cuerpo:</label>
        <textarea name="cos" required>{{ $article->cos }}</textarea>

        <label>QR (Opcional):</label>
        <input type="text" name="qr" value="{{ $article->qr }}">

        <button type="submit">Actualizar</button>
    </form>
@endsection
