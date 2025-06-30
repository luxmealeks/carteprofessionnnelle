{{-- resources/views/admin/dashboard-stats-card.blade.php --}}
@props([
    'title' => '',
    'value' => 0,
    'icon' => '',
    'evolution' => 0,
    'color' => 'primary'
])

@php
    $colors = [
        'primary' => [
            'bg' => 'rgba(12, 75, 142, 0.1)',
            'text' => '#0c4b8e',
            'border' => '#0c4b8e'
        ],
        'success' => [
            'bg' => 'rgba(40, 167, 69, 0.1)',
            'text' => '#28a745',
            'border' => '#28a745'
        ],
        'warning' => [
            'bg' => 'rgba(255, 193, 7, 0.1)',
            'text' => '#ffc107',
            'border' => '#ffc107'
        ],
        'danger' => [
            'bg' => 'rgba(220, 53, 69, 0.1)',
            'text' => '#dc3545',
            'border' => '#dc3545'
        ]
    ];

    $colorConfig = $colors[$color] ?? $colors['primary'];
@endphp

<div class="stats-card"
     style="--card-bg: {{ $colorConfig['bg'] }};
            --card-text: {{ $colorConfig['text'] }};
            --card-border: {{ $colorConfig['border'] }}"
     aria-label="Statistique: {{ $title }}">
    <div class="stats-card__header">
        <div class="stats-card__icon" aria-hidden="true">
            <i class="bi bi-{{ $icon }}"></i>
        </div>
        <h3 class="stats-card__title">{{ $title }}</h3>
    </div>

    <div class="stats-card__value">{{ number_format($value) }}</div>

    <div class="stats-card__evolution"
         data-tooltip="Évolution par rapport au mois dernier">
        <span class="stats-card__trend {{ $evolution > 0 ? 'up' : 'down' }}">
            <i class="bi bi-arrow-{{ $evolution > 0 ? 'up' : 'down' }}-right"></i>
            {{ abs($evolution) }}%
        </span>
        <span class="stats-card__evolution-label">vs mois dernier</span>
    </div>
</div>

@push('styles')
<style>
    .stats-card {
        --card-padding: 1.25rem;
        --icon-size: 40px;

        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: var(--card-padding);
        transition: all 0.3s ease;
        border-left: 4px solid var(--card-border);
        height: 100%;
        display: flex;
        flex-direction: column;
        will-change: transform;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .stats-card__header {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .stats-card__icon {
        width: var(--icon-size);
        height: var(--icon-size);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.75rem;
        font-size: 1.25rem;
        background-color: var(--card-bg);
        color: var(--card-text);
    }

    .stats-card__title {
        font-size: 0.95rem;
        font-weight: 500;
        color: #6c757d;
        margin: 0;
    }

    .stats-card__value {
        font-size: clamp(1.5rem, 3vw, 1.75rem);
        font-weight: 700;
        margin: 0.5rem 0;
        line-height: 1.2;
        color: var(--card-text);
        transition: transform 0.3s ease;
    }

    .stats-card:hover .stats-card__value {
        transform: scale(1.05);
    }

    .stats-card__evolution {
        display: flex;
        align-items: center;
        margin-top: auto;
        font-size: 0.85rem;
        padding-top: 0.5rem;
        border-top: 1px solid #f0f0f0;
        gap: 0.5rem;
    }

    .stats-card__trend {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-weight: 500;
    }

    .stats-card__trend.up {
        color: #28a745;
    }

    .stats-card__trend.down {
        color: #dc3545;
    }

    .stats-card__evolution-label {
        color: #6c757d;
    }

    @media (max-width: 768px) {
        .stats-card {
            --card-padding: 1rem;
            --icon-size: 36px;
        }

        .stats-card__value {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .stats-card {
            border-left-width: 3px;
        }

        .stats-card__header {
            flex-direction: column;
            align-items: flex-start;
        }

        .stats-card__icon {
            margin: 0 0 0.5rem 0;
        }

        .stats-card__evolution {
            flex-wrap: wrap;
        }
    }
</style>
@endpush
