<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification Carte Agent</title>

    <!-- Chargement local des polices -->
    <style>
        @font-face {
            font-family: 'Segoe UI';
            src: local('Segoe UI'), local('SegoeUI');
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            padding: 0;
            margin: 0;
            background-color: #f8f9fa;
        }
        .verification-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .verification-card {
            width: 100%;
            max-width: 600px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 30px;
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .agent-photo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .agent-photo {
            width: 120px;
            height: 150px;
            object-fit: cover;
            border: 2px solid #0c4b8e;
            border-radius: 4px;
        }
        .agent-info {
            margin-bottom: 20px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .validation-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background-color: #d1e7dd;
            color: #0f5132;
            border-radius: 6px;
            font-weight: 500;
            margin-top: 20px;
        }
    </style>

    <!-- Fallback si CDN ne charge pas -->
    <script>
        function loadFallbackStyles() {
            const style = document.createElement('style');
            style.textContent = `
                .bi::before {
                    display: inline-block;
                    content: "";
                    vertical-align: -.125em;
                    background-repeat: no-repeat;
                    background-size: 1rem 1rem;
                }
                .bi-check-circle-fill::before {
                    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%230f5132' viewBox='0 0 16 16'%3E%3Cpath d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/%3E%3C/svg%3E");
                }
                .bi-person-fill::before {
                    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236c757d' viewBox='0 0 16 16'%3E%3Cpath d='M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z'/%3E%3C/svg%3E");
                }
            `;
            document.head.appendChild(style);
        }

        // Si Bootstrap Icons ne charge pas après 2 secondes
        setTimeout(loadFallbackStyles, 2000);
    </script>

    <!-- CDN Bootstrap Icons avec fallback -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet" onerror="loadFallbackStyles()">
</head>
<body>
    <div class="verification-container">
        <div class="verification-card">
            <h2 class="text-center" style="margin-bottom: 24px;">Carte Professionnelle Validée</h2>

            <!-- Photo de l'agent -->
            <div class="agent-photo-container">
                @if($agent->photo && file_exists(public_path('storage/' . $agent->photo)))
                    <img src="{{ asset('storage/' . $agent->photo) }}" class="agent-photo" alt="Photo de l'agent">
                @else
                    <div style="width: 120px; height: 150px; background-color: #f8f9fa; border: 2px dashed #6c757d; border-radius: 4px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="bi bi-person-fill" style="font-size: 3rem; color: #6c757d;"></i>
                    </div>
                @endif
            </div>

            <!-- Informations de l'agent -->
            <div class="agent-info">
                <div class="info-item">
                    <strong>Nom:</strong> {{ $agent->prenom }} {{ $agent->nom }}
                </div>
                <div class="info-item">
                    <strong>Matricule:</strong> {{ $agent->matricule }}
                </div>
                <div class="info-item">
                    <strong>Fonction:</strong> {{ $agent->fonction ?? 'Non spécifié' }}
                </div>
                <div class="info-item">
                    <strong>Établissement:</strong> {{ $agent->etablissement->nom ?? 'Non spécifié' }}
                </div>
            </div>

            <!-- Badge de validation -->
            <div style="text-align: center;">
                <div class="validation-badge">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Cette carte est valide et enregistrée dans nos systèmes</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
