<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Ficha médica do pet</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            font-size: 12px;
        }
        .topo {
            border-bottom: 2px solid #198754;
            padding-bottom: 10px;
            margin-bottom: 16px;
        }
        .titulo {
            font-size: 22px;
            margin: 0;
            color: #198754;
        }
        .subtitulo {
            margin: 4px 0 0 0;
            font-size: 12px;
            color: #4b5563;
        }
        .bloco {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 12px;
            margin-bottom: 12px;
        }
        .bloco h2 {
            margin: 0 0 10px 0;
            font-size: 16px;
            color: #111827;
        }
        .linha {
            margin-bottom: 6px;
        }
        .rotulo {
            font-weight: bold;
        }
        .rodape {
            margin-top: 14px;
            font-size: 11px;
            color: #6b7280;
            border-top: 1px solid #d1d5db;
            padding-top: 8px;
        }
    </style>
</head>
<body>
    <div class="topo">
        <h1 class="titulo">Ficha Médica do Pet</h1>
        <p class="subtitulo">Documento para uso da clínica veterinária</p>
    </div>

    <div class="bloco">
        <h2>Dados do Pet</h2>
        <div class="linha"><span class="rotulo">ID da ficha:</span> #{{ $pet->id }}</div>
        <div class="linha"><span class="rotulo">Nome:</span> {{ $pet->nome }}</div>
        <div class="linha"><span class="rotulo">Raça:</span> {{ $pet->raca ?: 'Não informado' }}</div>
        <div class="linha"><span class="rotulo">Cor:</span> {{ $pet->cor ?: 'Não informado' }}</div>
        <div class="linha"><span class="rotulo">Nascimento:</span> {{ $pet->nascimento ? $pet->nascimento->format('d/m/Y') : 'Não informado' }}</div>
        <div class="linha"><span class="rotulo">Vacina:</span> {{ $pet->vacina ?: 'Não informado' }}</div>
        <div class="linha"><span class="rotulo">Data da vacina:</span> {{ $pet->data_vacina ? $pet->data_vacina->format('d/m/Y') : 'Não informado' }}</div>
        <div class="linha"><span class="rotulo">Doenças e alertas:</span> {{ $pet->doenca ?: 'Não informado' }}</div>
        <div class="linha"><span class="rotulo">Observações:</span> {{ $pet->observacao ?: 'Não informado' }}</div>
    </div>

    <div class="bloco">
        <h2>Dados do Tutor</h2>
        <div class="linha"><span class="rotulo">Nome:</span> {{ $pet->user ? $pet->user->nome : 'Não informado' }}</div>
        <div class="linha"><span class="rotulo">CPF:</span> {{ $pet->user ? $pet->user->cpf : 'Não informado' }}</div>
        <div class="linha"><span class="rotulo">Telefone:</span> {{ $pet->user ? $pet->user->telefone : 'Não informado' }}</div>
        <div class="linha"><span class="rotulo">E-mail:</span> {{ $pet->user ? $pet->user->email : 'Não informado' }}</div>
    </div>

    <div class="bloco">
        <h2>Consulta para a Clínica</h2>
        @if($consulta)
            <div class="linha"><span class="rotulo">Clínica:</span> {{ $consulta->clinica ? $consulta->clinica->nome : 'Não informado' }}</div>
            <div class="linha"><span class="rotulo">Data:</span> {{ $consulta->data ? $consulta->data->format('d/m/Y') : 'Não informado' }}</div>
            <div class="linha"><span class="rotulo">Hora:</span> {{ $consulta->hora ? substr((string)$consulta->hora, 0, 5) : 'Não informado' }}</div>
            <div class="linha"><span class="rotulo">Motivo:</span> {{ $consulta->motivo ?: 'Não informado' }}</div>
            <div class="linha"><span class="rotulo">Status:</span> {{ ucfirst($consulta->status) }}</div>
        @else
            <div class="linha">Não existe consulta vinculada a este pet para exibir no PDF.</div>
        @endif
    </div>

    <div class="rodape">
        <div>PDF gerado em {{ $dataGeracao }} às {{ $horaGeracao }}</div>
    </div>
</body>
</html>
