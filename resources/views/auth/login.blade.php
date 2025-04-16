@extends("headerPr")

@section("title", "Login")
<link href="{{ asset('css/form.css') }}" rel="stylesheet">

@push('scripts')
    <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.querySelector('form');
            
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                grecaptcha.ready(function() {
                    grecaptcha.execute("{{ env('RECAPTCHA_SITE_KEY') }}", {action: 'login'})
                        .then(function(token) {
                            // Añadir el token al formulario
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'g-recaptcha-response';
                            input.value = token;
                            loginForm.appendChild(input);
                            
                            // Enviar el formulario
                            loginForm.submit();
                        });
                });
            });
        });
    </script>
    <style>
        .g-recaptcha-info {
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 15px;
            text-align: center;
            padding: 5px;
            background-color: #f9f9f9;
            border-radius: 4px;
        }
    </style>
@endpush

@section("seccioProva")
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

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif
<div class="container">
    <form method="POST" class="auth-form" action="{{ route('login') }}" id="login-form">
        @csrf
        <label>Email:</label>
        <input type="email" name="email" value="{{ Cookie::get('remembered_user_email') ?? old('email') }}" required>
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        <input type="checkbox" name="remember" id="remember" 
        {{ old('remember') ? 'checked' : (Cookie::has('remembered_user_email') ? 'checked' : '') }}>
        <label for="remember">Recordar sesión</label>

        <div class="form-group">
            <a href="{{ route('password.forgot') }}">¿Has olvidado tu contraseña?</a>
        </div>

        <!-- reCAPTCHA v3 (invisible) -->
        <div class="g-recaptcha-info">Esta página está protegida por reCAPTCHA</div>
        
        <button class="btn btn-primary" type="submit">Iniciar sesión</button>
    </form>
</div>
@endsection
