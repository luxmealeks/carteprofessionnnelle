@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ajouter un établissement</h2>

    <form action="{{ route('etablissements.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nom" class="form-label">Nom de l’établissement</label>
            <input type="text" name="nom" id="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="ia_id" class="form-label">Inspection Académique</label>
            <select name="ia_id" id="ia_id" class="form-control" required>
                @foreach($ias as $ia)
                    <option value="{{ $ia->id }}">{{ $ia->nom }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
