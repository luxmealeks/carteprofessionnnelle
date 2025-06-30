@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Liste des IEF</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('iefs.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Ajouter une IEF
    </a>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Inspection Académique</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($iefs as $ief)
                <tr>
                    <td>{{ $ief->id }}</td>
                    <td>{{ $ief->nom }}</td>
                    <td>{{ $ief->ia->nom ?? '-' }}</td>
                    <td>
                        <a href="{{ route('iefs.edit', $ief->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> Modifier
                        </a>
                        <form action="{{ route('iefs.destroy', $ief->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Confirmer la suppression ?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
