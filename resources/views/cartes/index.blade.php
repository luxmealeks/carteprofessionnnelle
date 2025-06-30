@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Cartes des Agents</h1>

    <div class="row">
        @foreach($agents as $agent)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <img src="{{ asset('storage/photos/' . $agent->photo) }}" alt="Photo" class="rounded mb-3" width="100">
                        <h5 class="card-title">{{ $agent->prenom }} {{ $agent->nom }}</h5>
                        <p class="mb-1"><strong>Matricule :</strong> {{ $agent->matricule }}</p>
                        <p class="mb-1"><strong>Etablissement :</strong> {{ $agent->etablissement->nom ?? '-' }}</p>
                        <p class="mb-1"><strong>Corps :</strong> {{ $agent->corps->nom ?? '-' }}</p>
                        <p class="mb-1"><strong>Grade :</strong> {{ $agent->grade->nom ?? '-' }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
