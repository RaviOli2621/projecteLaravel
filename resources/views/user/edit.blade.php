@extends("headerPr")

@section("title", "Editar Usuario")

@section("seccioProva")
    <h1>Editar usuario</h1>

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

    <form action="{{ route('usuaris.update', $user) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Usuario:</label>
        <input type="text" name="username" value="{{ $user->Usuari }}" required>

        <label>Contraseña actual:</label>
        <input type="password" name="currentPassword" placeholder="Dejar en blanco para mantener la actual">

        <label>Contraseña:</label>
        <input type="password" name="password" placeholder="Dejar en blanco para mantener la actual">

        <label>Verifica contraseña:</label>
        <input type="password" name="password2" placeholder="Dejar en blanco para mantener la actual">

        <label>Foto:</label>
        <input type="file" name="photo">
        @if($user->Foto)
            <div>
                <img src="data:image/jpg;base64,{{$user->Foto}}" alt="Foto de perfil" style="max-width: 200px;">
                <p>Foto actual</p>
            </div>
        @endif

        <button type="submit">Actualizar</button>
    </form>
@endsection
