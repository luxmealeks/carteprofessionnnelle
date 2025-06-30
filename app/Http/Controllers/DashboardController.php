<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Activity;
use App\Models\InspectionAcademique;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $currentPeriod = now()->startOfMonth();
        $previousPeriod = now()->subMonth()->startOfMonth();

        $stats = $this->getStatistics($currentPeriod, $previousPeriod);
        $recentActivities = $this->getRecentActivities();

        return view('admin.dashboard', array_merge($stats, [
            'recentActivities' => $recentActivities,
            'inspection' => $this->getUserInspection()
        ]));
    }

    protected function getStatistics($currentPeriod, $previousPeriod)
    {
        $currentStats = [
            'total' => Agent::count(),
            'en_attente' => Agent::where('statut_photo', 'en_attente')->count(),
            'validees' => Agent::where('statut_photo', 'validee')->count(),
            'rejetees' => Agent::where('statut_photo', 'rejetee')->count(),
        ];

        $previousStats = [
            'total' => Agent::where('created_at', '<', $currentPeriod)->count(),
            'en_attente' => Agent::where('statut_photo', 'en_attente')
                            ->where('created_at', '<', $currentPeriod)->count(),
            'validees' => Agent::where('statut_photo', 'validee')
                            ->where('created_at', '<', $currentPeriod)->count(),
            'rejetees' => Agent::where('statut_photo', 'rejetee')
                            ->where('created_at', '<', $currentPeriod)->count(),
        ];

        return [
            'total' => $currentStats['total'],
            'en_attente' => $currentStats['en_attente'],
            'validees' => $currentStats['validees'],
            'rejetees' => $currentStats['rejetees'],
            'evolutions' => $this->calculateEvolutions($currentStats, $previousStats)
        ];
    }

    protected function calculateEvolutions($current, $previous)
    {
        return collect($current)->map(function ($value, $key) use ($previous) {
            if ($previous[$key] == 0) return $value == 0 ? 0 : 100;
            return round(($value - $previous[$key]) / $previous[$key] * 100, 1);
        })->toArray();
    }

    protected function getRecentActivities()
    {
        try {
            if (class_exists(Activity::class)) {
                return Activity::with('user')
                    ->latest()
                    ->take(5)
                    ->get()
                    ->map(function ($activity) {
                        return [
                            'title' => $activity->title,
                            'description' => $activity->description,
                            'icon' => $activity->icon ?? 'activity',
                            'color' => $activity->color ?? 'primary',
                            'time' => $activity->created_at->diffForHumans(),
                            'user' => $activity->user->name ?? 'Système'
                        ];
                    })->toArray();
            }
        } catch (\Exception $e) {
            logger()->error('Erreur activités: '.$e->getMessage());
        }

        return [
            [
                'title' => 'Bienvenue sur le tableau de bord',
                'description' => 'Le système a été initialisé avec succès',
                'icon' => 'rocket',
                'color' => 'success',
                'time' => 'Maintenant',
                'user' => 'Système'
            ]
        ];
    }

    protected function getUserInspection()
    {
        return Auth::check() && Auth::user()->inspection_academique_id
            ? InspectionAcademique::find(Auth::user()->inspection_academique_id)
            : InspectionAcademique::orderBy('nom')->first();
    }
}
