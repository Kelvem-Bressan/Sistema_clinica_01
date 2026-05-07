@extends('layouts.app')

@section('title', 'Consultas')

@section('content')
    <h1 class="h3 mb-3">
        @if ($modo === 'clinica')
            Consultas agendadas
        @else
            Minhas consultas
        @endif
    </h1>

    @if ($consultas->isEmpty())
        <p class="text-muted">Nenhum registro encontrado.</p>
    @else
        <div class="table-responsive card shadow-sm">
            <table class="table table-striped mb-0">
                <thead>
                <tr>
                    <th>Data</th>
                    <th>Hora</th>
                    @if ($modo === 'tutor')
                        <th>Clínica</th>
                    @else
                        <th>Pet</th>
                        <th>Tutor</th>
                    @endif
                    <th>Motivo</th>
                    <th>Status</th>
                    @if ($modo === 'clinica')
                        <th>Ação</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($consultas as $c)
                    <tr>
                        <td>{{ $c->data->format('d/m/Y') }}</td>
                        <td>{{ substr((string) $c->hora, 0, 5) }}</td>
                        @if ($modo === 'tutor')
                            <td>{{ $c->clinica->nome ?? '—' }}</td>
                        @else
                            <td>{{ $c->pet->nome ?? '—' }} <span class="text-muted small">#{{ $c->pet_id }}</span></td>
                            <td>{{ $c->user->nome ?? '—' }}</td>
                        @endif
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
                        @if ($modo === 'clinica')
                            <td>
                                @if ($c->status === 'pendente')
                                    <div class="d-flex gap-2">
                                        <form method="POST" action="{{ route('consultas.aceitar', $c->id) }}">
                                            @csrf
                                            <button class="btn btn-sm btn-success" type="submit">Aceitar</button>
                                        </form>
                                        <form method="POST" action="{{ route('consultas.recusar', $c->id) }}">
                                            @csrf
                                            <button class="btn btn-sm btn-danger" type="submit">Recusar</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted">Concluído</span>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    @if ($modo === 'tutor')
        <a class="btn tema-botao mt-3" href="{{ route('consultas.create') }}">Nova consulta</a>
    @endif
@endsection
