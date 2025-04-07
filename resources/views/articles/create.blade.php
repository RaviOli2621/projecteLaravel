@extends("headerPr")

@section("title", "Crear Artículo")

@section("seccioProva")
    <h1>Crear un Nuevo Artículo</h1>
    <form action="{{ route('articles.store') }}" method="POST">
        @csrf
        <label>Título:</label>
        <input type="text" name="titol" required>
        
        <input type="checkbox" name="copyTitol" id="copyTitol">

        <label>Cuerpo:</label>
        <textarea name="cos" required></textarea>

        <input type="checkbox" name="copyCos" id="copyCos">

        <button type="submit">Guardar</button>
    </form>
@endsection