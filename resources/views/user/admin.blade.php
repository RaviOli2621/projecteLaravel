@extends("headerPr")
@section("title", "Lista de Usuarios")
@section("seccioProva")
    <div class="articles-container">
        <div class="articles-header">
            <h1>Lista de Usuarios</h1>
        </div>
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

        <div class="articles-list">
            @foreach($users as $user)
                <div class="article-card">
                    <div class="article-content">
                        <h2 class="article-title">{{ $user->Usuari }}</h2>
                        <p class="article-body">{{ $user->Correu }}</p>
                    </div>
                    @if ($user->Admin == 0)
                        <div class="article-actions">
                            <form action="{{ route('usuaris.destroy', $user->Usuari) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">Eliminar</button>
                            </form>
                        </div>
                    @else 
                        <div class="article-actions">
                            Es Admin, no lo puedes tocar ;)
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
