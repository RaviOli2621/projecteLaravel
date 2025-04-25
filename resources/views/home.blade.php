@extends("headerPr")
@section("title","About")

@section("seccioProva")
    <h1>About</h1>
    <!-- Vista usada para debuggar el usuario -->
    <h3>Datos de la sesión:</h3>
    <p>Usuario en sesión debug: {{ session('debug_user') ?? 'No encontrado' }}</p>

    @if (Auth::check())
        <p>Usuario autenticado: {{ Auth::user()->Usuari }}</p>
    @else
        <p>No estás autenticado.</p>
    @endif
    <p>ID de la sesión: {{ session()->getId() }}</p>
@endsection
