@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifier l’établissement</h2>

    <form action="{{ route('etablissements.update', $etablissement->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom de l’établissement</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ $etablissement->nom }}" required>
        </div>

        <div class="mb-3">
            <label for="ia_id" class="form-label">Inspection Académique</label>
            <select name="ia_id" id="ia_id" class="form-control" required>
                @foreach($ias as $ia)
                    <option value="{{ $ia->id }}" {{ $etablissement->ia_id == $ia->id ? 'selected' : '' }}>
                        {{ $ia->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Mettre à jour</button>
    </form>
</div>
@endsection
