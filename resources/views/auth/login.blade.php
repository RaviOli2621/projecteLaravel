@extends("headerPr")

@section("title", "Login")

@section("seccioProva")
<form method="POST" action="{{ route('login') }}">
    @csrf
    <label>Email:</label>
    <input type="email" name="email" required>
    <label>Contraseña:</label>
    <input type="password" name="password" required>
    
    <button type="submit">Iniciar sesión</button>

</form>
@endsection
