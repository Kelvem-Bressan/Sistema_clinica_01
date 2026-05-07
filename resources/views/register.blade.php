<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4 mx-auto" style="max-width: 600px;">

        <h3 class="text-center mb-4">Cadastro</h3>

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

        <form method="POST" action="/register">
            @csrf

            <div class="mb-3">
                <label class="form-label">Tipo de conta</label>
                <select name="tipo" class="form-control" id="tipo" onchange="toggleFields()">
                    <option value="usuario">Usuário</option>
                    <option value="clinica">Clínica</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" required>
            </div>

            <div class="mb-3" id="cpfField">
                <label class="form-label">CPF</label>
                <input type="text" name="cpf" class="form-control" maxlength="11">
            </div>

            <div class="mb-3 d-none" id="cnpjField">
                <label class="form-label">CNPJ</label>
                <input type="text" name="cnpj" class="form-control" maxlength="14">
            </div>

                <div class="mb-3" id="emailField">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="mb-3" id="telefoneField">
                <label class="form-label">Telefone</label>
                <input type="text" name="telefone" class="form-control" maxlength="11">
            </div>

            <div class="mb-3 d-none" id="localizacaoField">

    <label class="form-label">Cidade</label>
    <input type="text" name="cidade" class="form-control" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase()">

    <label class="form-label mt-2">UF</label>
    <select name="uf" class="form-control">
        <option value="">Selecione</option>
        <option>AC</option>
        <option>AL</option>
        <option>AP</option>
        <option>AM</option>
        <option>BA</option>
        <option>CE</option>
        <option>DF</option>
        <option>ES</option>
        <option>GO</option>
        <option>MA</option>
        <option>MT</option>
        <option>MS</option>
        <option>MG</option>
        <option>PA</option>
        <option>PB</option>
        <option>PR</option>
        <option>PE</option>
        <option>PI</option>
        <option>RJ</option>
        <option>RN</option>
        <option>RS</option>
        <option>RO</option>
        <option>RR</option>
        <option>SC</option>
        <option>SP</option>
        <option>SE</option>
        <option>TO</option>
    </select>

</div>

            <div class="mb-3">
                <label class="form-label">Senha</label>
                <input type="password" name="password" class="form-control" required minlength="6">
            </div>

            <button class="btn btn-success w-100">Cadastrar</button>
        </form>

        <div class="text-center mt-3">
            <a href="/login">Já tenho conta</a>
        </div>
    </div>
</div>

<script>
function toggleFields() {
    let tipo = document.getElementById('tipo').value;

    if (tipo === 'clinica') {
        document.getElementById('cpfField').classList.add('d-none');
        document.getElementById('emailField').classList.add('d-none');
        document.getElementById('telefoneField').classList.add('d-none');

        document.getElementById('cnpjField').classList.remove('d-none');
        document.getElementById('localizacaoField').classList.remove('d-none');
    } else {
        document.getElementById('cpfField').classList.remove('d-none');
        document.getElementById('emailField').classList.remove('d-none');
        document.getElementById('telefoneField').classList.remove('d-none');

        document.getElementById('cnpjField').classList.add('d-none');
        document.getElementById('localizacaoField').classList.add('d-none');
    }
}
</script>

</body>
</html>