@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Liste des établissements</h2>

    <form method="GET" action="{{ route('etablissements.index') }}" class="row mb-4">
        <div class="col-md-4">
            <label for="ia_id" class="form-label">Filtrer par IA</label>
            <select name="ia_id" id="ia_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- Toutes les IA --</option>
                @foreach($ias as $ia)
                    <option value="{{ $ia->id }}" {{ request('ia_id') == $ia->id ? 'selected' : '' }}>
                        {{ $ia->nom }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>


    <form method="GET" action="{{ route('etablissements.index') }}" class="row mb-4">
        <div class="col-md-4">
            <label for="ia_id" class="form-label">Inspection Académique (IA)</label>
            <select name="ia_id" id="ia_id" class="form-select">
                <option value="">-- Toutes les IA --</option>
                @foreach ($ias as $ia)
                    <option value="{{ $ia->id }}" {{ request('ia_id') == $ia->id ? 'selected' : '' }}>
                        {{ $ia->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label for="ief_id" class="form-label">IEF</label>
            <select name="ief_id" id="ief_id" class="form-select">
                <option value="">-- Toutes les IEF --</option>
                @foreach ($iefs as $ief)
                    <option value="{{ $ief->id }}" {{ request('ief_id') == $ief->id ? 'selected' : '' }}>
                        {{ $ief->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">Filtrer</button>
            <a href="{{ route('etablissements.index') }}" class="btn btn-secondary">Réinitialiser</a>
        </div>
    </form>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Code</th>
                <th>IA</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($etablissements as $etab)
                <tr>
                    <td>{{ $etab->nom }}</td>
                    <td>{{ $etab->code }}</td>
                    <td>{{ $etab->ia->nom ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('etablissements.edit', $etab->id) }}" class="btn btn-sm btn-primary">Modifier</a>
                        <form action="{{ route('etablissements.destroy', $etab->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Aucun établissement trouvé.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('etablissements.create') }}" class="btn btn-success">Ajouter un établissement</a>
</div>
@endsection
