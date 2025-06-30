<!-- CDNs en HTTPS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<!-- Fichier CSS externe recommandé à la place -->
<style>
  :root {
    --navbar-height: 3.5rem;
    --shadow-default: 0 2px 4px rgba(0,0,0,0.05);
  }

  body { background-color: #f8f9fa; }

  .sidebar {
    position: sticky;
    top: var(--navbar-height);
    height: calc(100vh - var(--navbar-height));
    overflow-y: auto;
    z-index: 10; /* Valeur raisonnable */
  }

  .dashboard-container {
    padding: 1.25rem;
    background-color: white;
    border-radius: 0.5rem;
    box-shadow: var(--shadow-default);
  }

  .card-stat {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .card-stat:hover {
    transform: translateY(-0.3125rem);
    box-shadow: 0 0.625rem 1.25rem rgba(0,0,0,0.1);
  }

  @media (max-width: 768px) {
    .sidebar {
      height: auto;
      position: relative;
      top: 0;
    }
  }
</style>
