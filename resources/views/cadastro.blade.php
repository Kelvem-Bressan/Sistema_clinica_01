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

        <form method="POST" action="/register">

            <div class="mb-3">
                <label>Tipo de conta</label>
                <select name="tipo" class="form-control" id="tipo" onchange="toggleFields()">
                    <option value="usuario">Usuário</option>
                    <option value="clinica">Clínica</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Nome</label>
                <input type="text" name="nome" class="form-control" required>
            </div>

            <div class="mb-3" id="cpfField">
                <label>CPF</label>
                <input type="text" name="cpf" class="form-control">
            </div>

            <div class="mb-3 d-none" id="cnpjField">
                <label>CNPJ</label>
                <input type="text" name="cnpj" class="form-control">
            </div>

            <div class="mb-3" id="emailField">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="mb-3" id="telefoneField">
                <label>Telefone</label>
                <input type="text" name="telefone" class="form-control">
            </div>

            <div class="mb-3 d-none" id="localizacaoField">
                <label>Localização</label>
                <input type="text" name="localizacao" class="form-control">
            </div>

            <div class="mb-3">
                <label>Senha</label>
                <input type="password" name="password" class="form-control" required>
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