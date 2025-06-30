@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h4 mb-0">Liste des Inspections Académiques</h1>
                <a href="{{ route('ias.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus me-1"></i> Ajouter
                </a>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ias as $ia)
                        <tr>
                            <td>{{ $ia->nom }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('ias.edit', $ia->id) }}"
                                       class="btn btn-sm btn-primary">
                                        Modifier
                                    </a>
                                    <form action="{{ route('ias.destroy', $ia->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Confirmer la suppression ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center py-4 text-muted">
                                Aucune inspection académique enregistrée
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
    .gap-2 {
        gap: 0.5rem;
    }
</style>
@endsection
