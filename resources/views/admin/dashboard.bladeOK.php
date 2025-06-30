@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
    <div class="dashboard-container pt-5">
    <div class="dashboard-header mb-4">
        <h1 class="display-5 fw-bold">
            <i class="bi bi-speedometer2 me-2"></i>Tableau de bord
        </h1>
    </div>

     <!-- Statistiques -->
     <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card-stat bg-white">
                <div class="card-body">
                    <h5 class="card-title text-muted mb-3">Total Agents</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">{{ $total }}</h2>
                        <i class="bi bi-people-fill stat-icon text-primary"></i>
                    </div>
                    <div class="mt-2">
                        <span class="text-success"><i class="bi bi-arrow-up"></i> 5.2%</span>
                        <span class="text-muted ms-2">vs mois dernier</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-stat bg-white">
                <div class="card-body">
                    <h5 class="card-title text-muted mb-3">En Attente</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">{{ $en_attente }}</h2>
                        <i class="bi bi-hourglass-split stat-icon text-warning"></i>
                    </div>
                    <div class="mt-2">
                        <span class="text-danger"><i class="bi bi-arrow-down"></i> 2.1%</span>
                        <span class="text-muted ms-2">vs mois dernier</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-stat bg-white">
                <div class="card-body">
                    <h5 class="card-title text-muted mb-3">Validées</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">{{ $validees }}</h2>
                        <i class="bi bi-check-circle-fill stat-icon text-success"></i>
                    </div>
                    <div class="mt-2">
                        <span class="text-success"><i class="bi bi-arrow-up"></i> 8.7%</span>
                        <span class="text-muted ms-2">vs mois dernier</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-stat bg-white">
                <div class="card-body">
                    <h5 class="card-title text-muted mb-3">Rejetées</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">{{ $rejetees }}</h2>
                        <i class="bi bi-x-circle-fill stat-icon text-danger"></i>
                    </div>
                    <div class="mt-2">
                        <span class="text-success"><i class="bi bi-arrow-down"></i> 1.3%</span>
                        <span class="text-muted ms-2">vs mois dernier</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
</div>
@endsection
