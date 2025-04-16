@extends("headerPr")

@section("title", "Recuperar contraseña")

@section("seccioProva")
    <div class="container">
        <h1>Recuperar contraseña</h1>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    Enviar enlace de recuperación
                </button>
            </div>
        </form>
    </div>
@endsection
