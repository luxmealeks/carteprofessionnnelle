<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cartes du Lot {{ $lot->numero }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .page-break { page-break-after: always; }
        .card {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }
        .header { text-align: center; margin-bottom: 30px; }
        .photo-placeholder {
            width: 100px;
            height: 120px;
            border: 1px dashed #999;
            display: inline-block;
            vertical-align: top;
            margin-right: 20px;
        }
        .agent-info { display: inline-block; }
        .footer {
            margin-top: 30px;
            font-size: 0.8em;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    @foreach($agents as $index => $agent)
        <div class="card">
            <div class="header">
                <h2>Carte Professionnelle</h2>
                <p>{{ $ia->nom }} - {{ $ia->region }}</p>
                <p>Lot: {{ $lot->numero }} | Généré le: {{ now()->format('d/m/Y') }}</p>
            </div>

            <div class="photo-placeholder"></div>

            <div class="agent-info">
                <h3>{{ $agent->nom_complet }}</h3>
                <p><strong>Matricule:</strong> {{ $agent->matricule }}</p>
                <p><strong>Fonction:</strong> {{ $agent->fonction }}</p>
                <p><strong>Date de naissance:</strong> {{ $agent->date_naissance->format('d/m/Y') }}</p>
                <p><strong>Période validité:</strong> {{ now()->format('m/Y') }} - {{ now()->addYear()->format('m/Y') }}</p>
            </div>

            <div class="footer">
                <p>Cette carte est strictement personnelle et doit être présentée sur demande.</p>
                <p>Signature du directeur: ___________________________________</p>
            </div>
        </div>

        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>
