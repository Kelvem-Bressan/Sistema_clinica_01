<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .topo-logo {
            width: 100%;
            max-width: 360px;
            display: block;
            margin: 0 auto 20px auto;
        }
        .botao-acesso {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: #fff;
        }
        .botao-acesso:hover {
            background-color: #0b5ed7;
            border-color: #0b5ed7;
            color: #fff;
        }
    </style>
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="card shadow p-4" style="width: 420px;">
        <img src="{{ asset('images/logo-saude-pet.png') }}" alt="Saúde Pet" class="topo-logo">

        <h3 class="text-center mb-4">Entrar</h3>

        @if (session('status'))
            <div class="alert alert-success small">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger small">
                @foreach ($errors->all() as $erro)
                    <div>{{ $erro }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Tipo de acesso</label>
                <select name="tipo" class="form-select" id="tipo" required>
                    <option value="usuario" {{ old('tipo') === 'usuario' ? 'selected' : '' }}>Tutor (CPF)</option>
                    <option value="clinica" {{ old('tipo') === 'clinica' ? 'selected' : '' }}>Clínica (CNPJ)</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">CPF ou CNPJ</label>
                <input type="text" name="documento" class="form-control" value="{{ old('documento') }}" required autocomplete="username">
            </div>

            <div class="mb-3">
                <label class="form-label">Senha</label>
                <input type="password" name="password" class="form-control" required autocomplete="current-password">
            </div>

            <button class="btn botao-acesso w-100" id="botaoEntrar" type="submit">Entrar</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('register') }}">Criar conta</a>
        </div>

    </div>
</div>

<script>
    function atualizarCorBotao() {
        var tipo = document.getElementById('tipo').value;
        var botao = document.getElementById('botaoEntrar');
        if (tipo === 'clinica') {
            botao.style.backgroundColor = '#198754';
            botao.style.borderColor = '#198754';
        } else {
            botao.style.backgroundColor = '#0d6efd';
            botao.style.borderColor = '#0d6efd';
        }
    }
    document.getElementById('tipo').addEventListener('change', atualizarCorBotao);
    atualizarCorBotao();
</script>
</body>
</html>
