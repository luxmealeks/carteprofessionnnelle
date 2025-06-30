@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2>Détails du Lot #{{ $lot->id }}</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Inspection Académique:</strong> {{ $lot->inspectionAcademique->nom }}</p>
                    <p><strong>Date création:</strong> {{ $lot->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Nombre d'agents:</strong> {{ $lot->agents->count() }}</p>
                </div>
            </div>

            <a href="{{ route('lots.index') }}" class="btn btn-secondary mt-3">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
    </div>
</div>
@endsection
