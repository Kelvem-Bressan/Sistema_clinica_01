@extends('layouts.app')

@section('title', 'Editar ficha — '.$pet->nome)

@section('content')
    <h1 class="h3 mb-3">Editar ficha — {{ $pet->nome }}</h1>
    <p class="text-muted">ID da ficha: <strong>#{{ $pet->id }}</strong></p>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('pets.update', $pet) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input name="nome" class="form-control" value="{{ old('nome', $pet->nome) }}" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Raça</label>
                        <input name="raca" class="form-control" value="{{ old('raca', $pet->raca) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cor</label>
                        <input name="cor" class="form-control" value="{{ old('cor', $pet->cor) }}">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nascimento</label>
                    <input type="date" name="nascimento" class="form-control" value="{{ old('nascimento', $pet->nascimento ? $pet->nascimento->format('Y-m-d') : '') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Vacina</label>
                    <input name="vacina" class="form-control" value="{{ old('vacina', $pet->vacina) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Data da vacina</label>
                    <input type="date" name="data_vacina" class="form-control" value="{{ old('data_vacina', $pet->data_vacina ? $pet->data_vacina->format('Y-m-d') : '') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Doenças / alertas</label>
                    <input name="doenca" class="form-control" value="{{ old('doenca', $pet->doenca) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Observações</label>
                    <textarea name="observacao" class="form-control" rows="3">{{ old('observacao', $pet->observacao) }}</textarea>
                </div>
                @auth('web')
                    @if((int) $pet->user_id === (int) Auth::id())
                        <div class="mb-3">
                            <label class="form-label">Nova senha da ficha (opcional)</label>
                            <input type="password" name="senha_ficha" class="form-control" minlength="4" autocomplete="new-password">
                            <div class="form-text">Deixe em branco para manter a senha atual.</div>
                        </div>
                    @endif
                @endauth
                <div class="mb-3">
                    <label class="form-label">Nova foto</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>
                <button class="btn btn-primary" type="submit">Salvar</button>
                <a class="btn btn-link" href="{{ route('pets.show', $pet) }}">Voltar</a>
            </form>
        </div>
    </div>
@endsection
