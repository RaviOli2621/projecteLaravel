@extends("headerPr")
@section("title","About")

@section("seccioProva")
    <h1>About</h1>
    <!-- Mostrar los datos de la sesión -->
    <h3>Datos de la sesión:</h3>
    <p>Usuario en sesión debug: {{ session('debug_user') ?? 'No encontrado' }}</p>

    <!-- Verificar si el usuario está autenticado -->
    @if (Auth::check())
        <!-- Mostrar el nombre del usuario autenticado -->
        <p>Usuario autenticado: {{ Auth::user()->Usuari }}</p>
    @else
        <p>No estás autenticado.</p>
    @endif
    <!-- Verificar el ID de sesión -->
    <p>ID de la sesión: {{ session()->getId() }}</p>
@endsection
