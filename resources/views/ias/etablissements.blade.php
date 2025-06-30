@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Établissements de l'IA : {{ $ia->nom }}</h2>

    @if($ia->etablissements->isEmpty())
        <p>Aucun établissement enregistré pour cette IA.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Localisation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ia->etablissements as $etablissement)
                    <tr>
                        <td>{{ $etablissement->nom }}</td>
                        <td>{{ $etablissement->type }}</td>
                        <td>{{ $etablissement->localisation }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
