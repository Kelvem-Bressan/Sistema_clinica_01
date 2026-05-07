@extends('layouts.app')

@section('title', 'Ficha — '.$pet->nome)

@section('content')
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
        <div>
            <h1 class="h3 mb-1">{{ $pet->nome }}</h1>
            <p class="text-muted mb-0">ID da ficha: <strong class="text-dark">#{{ $pet->id }}</strong>
                @auth('web')
                    @if((int) $pet->user_id === (int) Auth::id())
                        <span class="badge bg-success ms-1">Você é o tutor</span>
                    @endif
                @endauth
                @auth('clinica')
                    <span class="badge bg-info text-dark ms-1">Acesso via senha da ficha</span>
                @endauth
            </p>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-primary" href="{{ route('pets.pdf', $pet) }}">Gerar PDF</a>
            <a class="btn btn-outline-primary" href="{{ route('pets.edit', $pet) }}">Editar</a>
            @auth('web')
                @if((int) $pet->user_id === (int) Auth::id())
                    <form method="POST" action="{{ route('pets.destroy', $pet) }}" onsubmit="return confirm('Remover este pet?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger" type="submit">Excluir</button>
                    </form>
                @endif
            @endauth
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Raça</dt>
                        <dd class="col-sm-8">{{ $pet->raca ?: '—' }}</dd>
                        <dt class="col-sm-4">Cor</dt>
                        <dd class="col-sm-8">{{ $pet->cor ?: '—' }}</dd>
                        <dt class="col-sm-4">Nascimento</dt>
                        <dd class="col-sm-8">{{ $pet->nascimento ? \Carbon\Carbon::parse($pet->nascimento)->format('d/m/Y') : '—' }}</dd>
                        <dt class="col-sm-4">Vacina</dt>
                        <dd class="col-sm-8">{{ $pet->vacina ?: '—' }}</dd>
                        <dt class="col-sm-4">Data vacina</dt>
                        <dd class="col-sm-8">{{ $pet->data_vacina ? \Carbon\Carbon::parse($pet->data_vacina)->format('d/m/Y') : '—' }}</dd>
                        <dt class="col-sm-4">Doenças / alertas</dt>
                        <dd class="col-sm-8">{{ $pet->doenca ?: '—' }}</dd>
                        <dt class="col-sm-4">Observações</dt>
                        <dd class="col-sm-8">{{ $pet->observacao ?: '—' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            @if ($pet->foto)
                <div class="card shadow-sm">
                    <img src="{{ asset('storage/'.$pet->foto) }}" class="card-img-top" alt="Foto de {{ $pet->nome }}">
                </div>
            @endif
        </div>
    </div>
@endsection
