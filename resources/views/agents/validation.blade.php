@extends('layouts.app')

@section('content')
<h2>Photos en attente de validation</h2>

<table class="table">
    <thead>
        <tr>
            <th>Photo</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Matricule</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($agents as $agent)
        <tr>
            <td>
                @if ($agent->photo)
                    <img src="{{ asset('storage/' . $agent->photo) }}" width="80">
                @endif
            </td>
            <td>{{ $agent->nom }}</td>
            <td>{{ $agent->prenom }}</td>
            <td>{{ $agent->matricule }}</td>
            <td>
                <form action="{{ route('agents.validate', $agent->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button class="btn btn-success btn-sm">Valider</button>
                </form>

                <form action="{{ route('agents.reject', $agent->id) }}" method="POST" style="display:inline; margin-left: 5px;">
                    @csrf
                    <input type="text" name="motif" placeholder="Motif rejet" required>
                    <button class="btn btn-danger btn-sm">Rejeter</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
