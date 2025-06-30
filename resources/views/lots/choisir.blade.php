@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h4 mb-0">
                    <i class="bi bi-printer me-2"></i>Gestion des lots d'impression
                </h2>
                <a href="{{ route('lots.create') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle me-1"></i> Créer un lot
                </a>
            </div>
        </div>

        <div class="card-body">
            @if($lots->isEmpty())
                <div class="alert alert-info text-center py-4">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    Aucun lot disponible pour impression.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nom du lot</th>
                                <th>Statut</th>
                                <th>Agents</th>
                                <th>Création</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lots as $lot)
                            <tr>
                                <td class="fw-bold">{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge bg-primary rounded-pill fs-6 px-3 py-1">
                                        {{ $lot->numero }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $lot->statut === 'complet' ? 'success' : 'warning' }} rounded-pill">
                                        {{ ucfirst($lot->statut) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary rounded-pill">
                                        {{ $lot->agents_count }} agents
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $lot->created_at->format('d/m/Y H:i') }}
                                        <br>
                                        <span class="fst-italic">par {{ $lot->creator->name ?? 'Système' }}</span>
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('lots.imprimer', $lot->id) }}" method="POST" target="_blank" class="print-form">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success"
                                                    data-bs-toggle="tooltip" title="Imprimer le lot"
                                                    @if($lot->agents_count === 0) disabled @endif>
                                                <i class="bi bi-printer-fill me-1"></i> Imprimer
                                            </button>
                                            @if($lot->agents_count === 0)
                                            <small class="text-danger d-block mt-1">Aucun agent dans ce lot</small>
                                            @endif
                                        </form>

                                        <a href="{{ route('lots.show', $lot->id) }}"
                                           class="btn btn-sm btn-outline-primary"
                                           data-bs-toggle="tooltip" title="Voir détails">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>

                                        <button class="btn btn-sm btn-outline-danger delete-lot"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                data-lot-id="{{ $lot->id }}"
                                                data-lot-name="{{ $lot->numero }}"
                                                title="Supprimer le lot">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted small">
                        Affichage de {{ $lots->firstItem() }} à {{ $lots->lastItem() }} sur {{ $lots->total() }} lots
                    </div>
                    <div>
                        {{ $lots->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer le lot <strong id="lotName"></strong> ?</p>
                    <p class="text-danger">Cette action est irréversible et supprimera également toutes les cartes associées.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash-fill me-1"></i> Supprimer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }
    .badge {
        font-weight: 500;
    }
    .btn-sm {
        padding: 0.375rem 0.75rem;
        transition: all 0.2s ease;
    }
    .print-form {
        display: inline-block;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enable tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Button animations
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', () => {
            button.style.transform = 'translateY(-2px)';
            button.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
        });
        button.addEventListener('mouseleave', () => {
            button.style.transform = '';
            button.style.boxShadow = '';
        });
    });

    // Delete modal handling
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const lotId = button.getAttribute('data-lot-id');
            const lotName = button.getAttribute('data-lot-name');

            document.getElementById('lotName').textContent = lotName;
            document.getElementById('deleteForm').action = `/lots/${lotId}`;
        });
    }

    // Print form handling with feedback
    const printForms = document.querySelectorAll('.print-form');
    printForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Impression...';
            btn.disabled = true;

            // Re-enable button after 3 seconds in case the print window is blocked
            setTimeout(() => {
                btn.innerHTML = '<i class="bi bi-printer-fill me-1"></i> Imprimer';
                btn.disabled = false;
            }, 3000);
        });
    });
});
</script>
@endpush
