@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ajouter une Inspection Académique</h2>

    @if(session('success'))
        <div class="alert alert-success mt-2">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('ias.store') }}" method="POST">
        @csrf

        <div class="form-group mt-3">
            <label for="nom">Nom de l'IA</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Ajouter</button>
    </form>
</div>
@endsection
