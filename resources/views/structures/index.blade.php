@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Structures (Directions & Services)</h2>

    <a href="{{ route('structures.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Ajouter une structure
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Nom</th>
                <th>Type</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($structures as $structure)
                <tr>
                    <td>{{ $structure->nom }}</td>
                    <td>{{ ucfirst($structure->type) }}</td>
                    <td>
                        <a href="{{ route('structures.edit', $structure) }}" class="btn btn-sm btn-warning">
                            Modifier
                        </a>
                        <form action="{{ route('structures.destroy', $structure) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmer la suppression ?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">Aucune structure enregistrée.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
