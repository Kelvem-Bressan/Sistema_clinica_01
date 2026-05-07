@extends('layouts.app')

@section('title', 'Agendar consulta')

@section('content')
    <h1 class="h3 mb-3">Agendar consulta</h1>

    @if ($pets->isEmpty())
        <div class="alert alert-warning">Cadastre um pet antes de agendar.</div>
        <a class="btn tema-botao" href="{{ route('pets.create') }}">Cadastrar pet</a>
    @elseif ($clinicas->isEmpty())
        <div class="alert alert-warning">Não há clínicas cadastradas.</div>
    @else
        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('consultas.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Pet</label>
                        <select name="pet_id" class="form-select" required>
                            <option value="">Selecione</option>
                            @foreach ($pets as $pet)
                                <option value="{{ $pet->id }}" {{ (string) old('pet_id') === (string) $pet->id ? 'selected' : '' }}>
                                    {{ $pet->nome }} (ficha #{{ $pet->id }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Clínica</label>
                        <select name="clinica_id" class="form-select" required>
                            <option value="">Selecione</option>
                            @foreach ($clinicas as $clinica)
                                <option value="{{ $clinica->id }}" {{ (string) old('clinica_id') === (string) $clinica->id ? 'selected' : '' }}>
                                    {{ $clinica->nome }} — {{ $clinica->cidade }}/{{ $clinica->uf }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data</label>
                            <input type="date" name="data" class="form-control" value="{{ old('data') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Hora</label>
                            <input type="time" name="hora" class="form-control" value="{{ old('hora') }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Motivo</label>
                        <textarea name="motivo" class="form-control" rows="3" required>{{ old('motivo') }}</textarea>
                    </div>
                    <button class="btn tema-botao" type="submit">Confirmar agendamento</button>
                    <a class="btn btn-link" href="{{ route('dashboard') }}">Cancelar</a>
                </form>
            </div>
        </div>
    @endif
@endsection
