@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Paramètres de l’application</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('settings.update') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nom de l’Application</label>
            <input type="text" name="app_name" value="{{ $settings['app_name'] ?? '' }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Email de contact</label>
            <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Message de pied de page</label>
            <textarea name="footer_message" class="form-control">{{ $settings['footer_message'] ?? '' }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
