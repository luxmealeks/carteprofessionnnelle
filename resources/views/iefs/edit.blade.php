@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Modifier une IEF</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('iefs.update', $ief->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom de l'IEF</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ $ief->nom }}" required>
        </div>

        <div class="mb-3">
            <label for="ia_id" class="form-label">Inspection Académique</label>
            <select name="ia_id" id="ia_id" class="form-select" required>
                @foreach($ias as $ia)
                    <option value="{{ $ia->id }}" {{ $ief->ia_id == $ia->id ? 'selected' : '' }}>
                        {{ $ia->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Mettre à jour
        </button>
        <a href="{{ route('iefs.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
