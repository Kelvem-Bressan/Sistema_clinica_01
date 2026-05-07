<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Clínica Veterinária')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @php
        $corPrincipal = '#0d6efd';
        $corEscura = '#0b5ed7';
        if (Auth::guard('clinica')->check()) {
            $corPrincipal = '#198754';
            $corEscura = '#146c43';
        }
    @endphp
    <style>
        .tema-barra { background-color: {{ $corPrincipal }}; }
        .tema-botao {
            background-color: {{ $corPrincipal }};
            border-color: {{ $corPrincipal }};
            color: #fff;
        }
        .tema-botao:hover {
            background-color: {{ $corEscura }};
            border-color: {{ $corEscura }};
            color: #fff;
        }
        .tema-borda {
            border-color: {{ $corPrincipal }} !important;
            color: {{ $corPrincipal }} !important;
        }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg navbar-dark tema-barra mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Clínica Vet</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto">
                @auth('web')
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pets.index') }}">Meus pets</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pets.create') }}">Cadastrar pet</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('consultas.create') }}">Agendar consulta</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('consultas.index') }}">Minhas consultas</a></li>
                @endauth
                @auth('clinica')
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('consultas.index') }}">Consultas</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('ficha.create') }}">Desbloquear ficha</a></li>
                @endauth
            </ul>
            @if(Auth::guard('web')->check() || Auth::guard('clinica')->check())
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button class="btn btn-outline-light btn-sm" type="submit">Sair</button>
                </form>
            @endif
        </div>
    </div>
</nav>

<main class="container flex-grow-1 pb-5">
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $erro)
                <div>{{ $erro }}</div>
            @endforeach
        </div>
    @endif
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
