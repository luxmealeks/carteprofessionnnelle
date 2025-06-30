<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $lot->label }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .page-break { page-break-after: always; }
        .card {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $lot->label }}</h1>
        <p>Inspection: {{ $inspection->nom }} - {{ $inspection->region }}</p>
        <p>Date de génération: {{ $lot->date_generation->format('d/m/Y H:i') }}</p>
    </div>

    @foreach($agents as $agent)
        <div class="card">
            <h2>{{ $agent->nom_complet }}</h2>
            <p>Matricule: {{ $agent->matricule }}</p>
            <p>Fonction: {{ $agent->fonction }}</p>
            <p>Établissement: {{ $agent->etablissement->nom ?? 'Non affecté' }}</p>

            @if($agent->photo)
                <div style="margin-top: 20px;">
                    <img src="{{ storage_path('app/public/'.$agent->photo) }}"
                         style="max-width: 150px; max-height: 150px;">
                </div>
            @endif
        </div>

        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>
