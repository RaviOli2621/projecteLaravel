@extends("headerPr")

@section("title", "Crear Artículo")

@section("seccioProva")
    <h1>Crear un Nuevo Artículo</h1>
    <form action="{{ route('articulos.store') }}" method="POST">
        @csrf
        <label>Usuario:</label>
        <input type="text" name="Usuari" required>

        <label>Título:</label>
        <input type="text" name="titol" required>

        <label>Cuerpo:</label>
        <textarea name="cos" required></textarea>

        <label>QR (Opcional):</label>
        <input type="text" name="qr">

        <button type="submit">Guardar</button>
    </form>
@endsection