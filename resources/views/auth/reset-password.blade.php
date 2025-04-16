@extends("headerPr")

@section("title", "Restablecer contraseña")
@section("seccioProva")
<link href="{{ asset('css/form.css') }}" rel="stylesheet">

<div class="container">
    <div class="auth-form">
        <h2>Restablecer contraseña</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.reset') }}">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="form-group">
                <label for="email-display">Correo electrónico</label>
                <input id="email-display" type="email" class="form-control" value="{{ $email }}" disabled>
                <p class="form-text text-muted">Este es el correo asociado a tu cuenta.</p>
            </div>

            <div class="form-group">
                <label for="password">Nueva contraseña</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                <p class="form-text text-muted">La contraseña debe tener al menos 8 caracteres.</p>
            </div>

            <div class="form-group">
                <label for="password-confirm">Confirmar contraseña</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    Restablecer contraseña
                </button>
            </div>
        </form>
    </div>
</div>
@endsection