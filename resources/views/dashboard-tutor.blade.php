@extends('layouts.app')

@section('title', 'Painel do tutor')

@section('content')
    <h1 class="h3 mb-3">Olá, {{ Auth::user()->nome }}</h1>
    <p class="text-muted">Cadastre seus animais, mantenha a ficha médica e agende consultas nas clínicas parceiras.</p>

    <div class="row g-3 mt-2">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5">Pets</h2>
                    <p class="small text-muted mb-3"></p>
                    <a class="btn tema-botao" href="{{ route('pets.create') }}">Cadastrar pet</a>
                    <a class="btn btn-outline-primary tema-borda" href="{{ route('pets.index') }}">Ver meus pets</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h2 class="h5">Consultas</h2>
                    <p class="small text-muted mb-3">Escolha o pet, a clínica, data e horário.</p>
                    <a class="btn tema-botao" href="{{ route('consultas.create') }}">Agendar consulta</a>
                    <a class="btn btn-outline-primary tema-borda" href="{{ route('consultas.index') }}">Ver agendamentos</a>
                </div>
            </div>
        </div>
    </div>
@endsection
