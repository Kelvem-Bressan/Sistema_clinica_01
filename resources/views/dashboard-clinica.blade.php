@extends('layouts.app')

@section('title', 'Painel da clínica')

@section('content')
    <h1 class="h3 mb-1">{{ $clinica->nome }}</h1>
    <p class="text-muted mb-4">{{ $clinica->cidade }}/{{ $clinica->uf }} · CNPJ {{ $clinica->cnpj }}</p>

    <div class="d-flex flex-wrap gap-2 mb-4">
        <a class="btn btn-outline-primary tema-borda" href="{{ route('consultas.index') }}">Lista de consultas</a>
        <a class="btn tema-botao" href="{{ route('ficha.create') }}">Desbloquear ficha por ID e senha</a>
    </div>

    <h2 class="h5 mb-3">Próximas consultas</h2>
    @if ($consultas->isEmpty())
        <p class="text-muted">Nenhuma consulta agendada no momento.</p>
    @else
        <div class="table-responsive card shadow-sm">
            <table class="table table-striped mb-0">
                <thead>
                <tr>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Pet</th>
                    <th>Tutor</th>
                    <th>Motivo</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($consultas as $c)
                    <tr>
                        <td>{{ $c->data->format('d/m/Y') }}</td>
                        <td>{{ substr((string) $c->hora, 0, 5) }}</td>
                        <td>{{ $c->pet->nome ?? '—' }} <span class="text-muted small">#{{ $c->pet_id }}</span></td>
                        <td>{{ $c->user->nome ?? '—' }}</td>
                        <td>{{ $c->motivo }}</td>
                        <td>
                            @if ($c->status === 'aceita')
                                <span class="badge bg-success">Aceita</span>
                            @elseif ($c->status === 'recusada')
                                <span class="badge bg-danger">Recusada</span>
                            @else
                                <span class="badge bg-warning text-dark">Pendente</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
