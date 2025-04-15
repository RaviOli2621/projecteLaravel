@extends("headerPr")

@section("title", "Signin")

@section("seccioProva")
<form method="POST" action="{{ route('register') }}">
    @csrf
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <!-- Campo para el nombre de usuario -->
    <label for="name">Nombre de usuario:</label>
    <input type="text" name="name" id="name" required>
    
    <!-- Campo para el correo electrónico -->
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    
    <!-- Campo para la contraseña -->
    <label for="password">Contraseña:</label>
    <input type="password" name="password" id="password" required>
    
    <!-- Campo para la confirmación de la contraseña -->
    <label for="password_confirmation">Confirmar contraseña:</label>
    <input type="password" name="password_confirmation" id="password_confirmation" required>

    <!-- Botón de registro -->
    <button type="submit">Registrar</button>
</form>
@endsection
