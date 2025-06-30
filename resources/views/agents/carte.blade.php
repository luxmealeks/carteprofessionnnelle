<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carte Agent - {{ $agent->nom }}</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            background-color: #f5f7fa;
            font-family: 'Arial', sans-serif;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ddd;
        }
        .title {
            font-size: 24px;
            color: #0c4b8e;
            font-weight: bold;
        }
        .canvas-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }
        .card-wrapper {
            position: relative;
            margin-bottom: 30px;
        }
        canvas {
            background-color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border: 1px solid #ddd;
        }
        .card-label {
            position: absolute;
            top: -25px;
            left: 10px;
            font-weight: bold;
            color: #0c4b8e;
            background: white;
            padding: 0 10px;
        }
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        .btn-primary {
            background-color: #0c4b8e;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0a3a6e;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn:active {
            transform: translateY(0);
        }
        .btn-icon {
            width: 18px;
            height: 18px;
            fill: currentColor;
        }
        @media print {
            body { padding: 0; background: none; }
            .no-print { display: none; }
            canvas { box-shadow: none; border: none; }
            .card-wrapper { page-break-after: always; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Carte Professionnelle - {{ $agent->prenom }} {{ $agent->nom }}</div>
        <div class="action-buttons no-print">
            <button class="btn btn-primary" onclick="window.print()">
                <svg class="btn-icon" viewBox="0 0 24 24">
                    <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
                </svg>
                Imprimer
            </button>
            <a href="/agents/{{ $agent->id }}/carte/download" class="btn btn-secondary">
                <svg class="btn-icon" viewBox="0 0 24 24">
                    <path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
                </svg>
                Télécharger PDF
            </a>
        </div>
    </div>

    <div class="canvas-container">
        <!-- Recto -->
        <div class="card-wrapper">
            <div class="card-label">Recto</div>
            <canvas id="cardRecto" width="856" height="540"></canvas>
        </div>

        <!-- Verso -->
        <div class="card-wrapper">
            <div class="card-label">Verso</div>
            <canvas id="cardVerso" width="856" height="540"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            // Configuration
            const config = {
                cardWidth: 856,
                cardHeight: 540,
                textColor: '#0c4b8e',
                secondaryColor: '#333333',
                primaryFont: 'bold 28px Arial',
                secondaryFont: '20px Arial',
                smallFont: '16px Arial'
            };

            // Données de l'agent
            const agent = {
                nom: "{{ addslashes($agent->nom) }}",
                prenom: "{{ addslashes($agent->prenom) }}",
                matricule: "{{ addslashes($agent->matricule) }}",
                fonction: "{{ addslashes($agent->fonction ?? 'Non spécifié') }}",
                etablissement: "{{ addslashes($agent->etablissement->nom ?? 'Non affecté') }}",
                inspection: "{{ addslashes($agent->inspectionAcademique->nom ?? '') }}",
                photo: "{{ $agent->photo ? asset('storage/' . $agent->photo) : asset('images/default-avatar.png') }}",
                signature: "{{ asset('images/signature_directeur.png') }}",
                cachet: "{{ asset('images/cachet_ministere.png') }}",
                validite: "{{ now()->year }} - {{ now()->addYears(5)->year }}",
                qrCodeUrl: "{{ route('agents.verify', $agent->id) }}"
            };

            // Chargement des images avec gestion des erreurs
            function loadImage(url) {
                return new Promise((resolve) => {
                    const img = new Image();
                    img.crossOrigin = 'Anonymous';
                    img.onload = () => resolve(img);
                    img.onerror = () => {
                        console.error('Erreur de chargement:', url);
                        resolve(null);
                    };
                    img.src = url;
                });
            }

            // Génération des cartes
            async function generateCards() {
                try {
                    // Charger toutes les images
                    const [photo, signature, cachet] = await Promise.all([
                        loadImage(agent.photo),
                        loadImage(agent.signature),
                        loadImage(agent.cachet)
                    ]);

                    // Recto
                    const recto = document.getElementById('cardRecto');
                    const ctxRecto = recto.getContext('2d');

                    // Fond blanc
                    ctxRecto.fillStyle = 'white';
                    ctxRecto.fillRect(0, 0, config.cardWidth, config.cardHeight);

                    // Bordure
                    ctxRecto.strokeStyle = config.textColor;
                    ctxRecto.lineWidth = 10;
                    ctxRecto.strokeRect(5, 5, config.cardWidth-10, config.cardHeight-10);

                    // En-tête
                    ctxRecto.fillStyle = config.textColor;
                    ctxRecto.fillRect(0, 0, config.cardWidth, 80);

                    // Logo et titre
                    ctxRecto.fillStyle = 'white';
                    ctxRecto.font = 'bold 24px Arial';
                    ctxRecto.textAlign = 'center';
                    ctxRecto.fillText('REPUBLIQUE DU SENEGAL', config.cardWidth/2, 40);
                    ctxRecto.font = 'bold 20px Arial';
                    ctxRecto.fillText('MINISTERE DE LA FONCTION PUBLIQUE', config.cardWidth/2, 70);

                    // Photo
                    if (photo) {
                        ctxRecto.drawImage(photo, 650, 120, 160, 200);
                    }

                    // Informations agent
                    ctxRecto.textAlign = 'left';
                    ctxRecto.fillStyle = config.textColor;
                    ctxRecto.font = config.primaryFont;
                    ctxRecto.fillText(`${agent.prenom} ${agent.nom}`, 50, 150);

                    ctxRecto.font = config.secondaryFont;
                    ctxRecto.fillStyle = config.secondaryColor;
                    ctxRecto.fillText(`Matricule: ${agent.matricule}`, 50, 200);
                    ctxRecto.fillText(`Fonction: ${agent.fonction}`, 50, 250);
                    ctxRecto.fillText(`Établissement: ${agent.etablissement}`, 50, 300);
                    ctxRecto.fillText(`Inspection: ${agent.inspection}`, 50, 350);

                    // QR Code (généré dynamiquement)
                    const qrSize = 100;
                    const qrX = config.cardWidth - qrSize - 30;
                    const qrY = config.cardHeight - qrSize - 30;

                    // Verso
                    const verso = document.getElementById('cardVerso');
                    const ctxVerso = verso.getContext('2d');

                    // Fond blanc
                    ctxVerso.fillStyle = 'white';
                    ctxVerso.fillRect(0, 0, config.cardWidth, config.cardHeight);

                    // Bordure
                    ctxVerso.strokeStyle = config.textColor;
                    ctxVerso.lineWidth = 10;
                    ctxVerso.strokeRect(5, 5, config.cardWidth-10, config.cardHeight-10);

                    // Cachet
                    if (cachet) {
                        ctxVerso.drawImage(cachet, 50, 100, 200, 200);
                    }

                    // Signature
                    if (signature) {
                        ctxVerso.drawImage(signature, 550, 350, 200, 80);
                    }

                    // Texte verso
                    ctxVerso.fillStyle = config.textColor;
                    ctxVerso.font = 'bold 22px Arial';
                    ctxVerso.fillText('CARTE PROFESSIONNELLE', 50, 50);

                    ctxVerso.fillStyle = config.secondaryColor;
                    ctxVerso.font = config.secondaryFont;
                    ctxVerso.fillText(`Validité: ${agent.validite}`, 50, 100);

                    // Mentions légales
                    ctxVerso.font = config.smallFont;
                    ctxVerso.fillText('Cette carte est la propriété du Ministère', 50, 400);
                    ctxVerso.fillText('Toute falsification est passible de poursuites', 50, 430);
                    ctxVerso.fillText('En cas de perte, merci de contacter:', 50, 460);
                    ctxVerso.fillText('direction@mfpt.sn - Tel: 33 123 45 67', 50, 490);

                } catch (error) {
                    console.error('Erreur lors de la génération:', error);
                    alert("Une erreur est survenue lors de la génération de la carte");
                }
            }

            generateCards();
        });
    </script>
</body>
</html>
