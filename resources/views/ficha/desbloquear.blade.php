@extends('layouts.app')

@section('title', 'Desbloquear ficha')

@section('content')
    <h1 class="h3 mb-3">Desbloquear ficha médica</h1>
    <p class="text-muted">Informe o <strong>ID da ficha</strong> fornecido pelo tutor e a <strong>senha da ficha</strong>. O acesso vale para esta sessão e permite visualizar e editar o prontuário.</p>

    <div class="card shadow-sm" style="max-width: 480px;">
        <div class="card-body">
            <form method="POST" action="{{ route('ficha.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">ID da ficha (número)</label>
                    <input type="number" name="pet_id" class="form-control" value="{{ old('pet_id') }}" required min="1">
                </div>
                <div class="mb-3">
                    <label class="form-label">Senha da ficha</label>
                    <input type="password" name="senha_ficha" class="form-control" required autocomplete="current-password">
                </div>
                <button class="btn btn-primary" type="submit">Desbloquear</button>
                <a class="btn btn-link" href="{{ route('dashboard') }}">Voltar</a>
            </form>
        </div>
    </div>
@endsection
