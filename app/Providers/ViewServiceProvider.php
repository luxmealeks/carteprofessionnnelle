<?php

namespace App\Providers;
use App\Models\Agent;
use App\Models\Photo;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('partials.sidebar', function ($view) {
            $view->with([
                'pending_agents' => Agent::where('statut_photo', 'en_attente')->count(),
                'pending_photos' => Agent::where('statut_photo', 'en_attente')->count()
            ]);
        });
    }
}
