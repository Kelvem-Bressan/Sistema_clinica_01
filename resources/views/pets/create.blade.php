@extends('layouts.app')

@section('title', 'Cadastrar pet')

@section('content')
    <h1 class="h3 mb-3">Cadastrar pet</h1>
    <p class="text-muted">Defina uma <strong>senha da ficha</strong></p>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('pets.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input name="nome" class="form-control" value="{{ old('nome') }}" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Raça</label>
                        <input name="raca" class="form-control" value="{{ old('raca') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Cor</label>
                        <input name="cor" class="form-control" value="{{ old('cor') }}">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nascimento</label>
                    <input type="date" name="nascimento" class="form-control" value="{{ old('nascimento') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Vacina</label>
                    <input name="vacina" class="form-control" value="{{ old('vacina') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Data da vacina</label>
                    <input type="date" name="data_vacina" class="form-control" value="{{ old('data_vacina') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Doenças / alertas</label>
                    <input name="doenca" class="form-control" value="{{ old('doenca') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Observações</label>
                    <textarea name="observacao" class="form-control" rows="3">{{ old('observacao') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Senha da ficha médica</label>
                    <input type="password" name="senha_ficha" class="form-control" required minlength="4" autocomplete="new-password">
                </div>
                <div class="mb-3">
                    <label class="form-label">Foto</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>
                <button class="btn btn-success" type="submit">Salvar</button>
                <a class="btn btn-link" href="{{ route('pets.index') }}">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
