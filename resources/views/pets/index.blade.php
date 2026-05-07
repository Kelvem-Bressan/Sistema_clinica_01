@extends('layouts.app')

@section('title', 'Meus pets')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Meus pets</h1>
        <a class="btn btn-primary" href="{{ route('pets.create') }}">Novo pet</a>
    </div>

    @if ($pets->isEmpty())
        <p class="text-muted">Nenhum pet cadastrado ainda.</p>
    @else
        <div class="list-group shadow-sm">
            @foreach ($pets as $pet)
                <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                   href="{{ route('pets.show', $pet) }}">
                    <div>
                        <strong>{{ $pet->nome }}</strong>
                        <span class="text-muted small ms-2">Ficha #{{ $pet->id }}</span>
                    </div>
                    <span class="badge bg-secondary">Ver ficha</span>
                </a>
            @endforeach
        </div>
    @endif
@endsection
