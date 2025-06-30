<?php

namespace App\Providers;
use App\Models\Agent;
use App\Models\Photo;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\DropdownRepository::class,
            function ($app) {
                return new \App\Repositories\DropdownRepository();
            }
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            \View::addLocation(storage_path('app/compiled_views'));
        }

        View::composer('partials.sidebar', function ($view) {
            $view->with([
                'pending_agents' => Agent::where('statut_photo', 'en_attente')->count(),
                'pending_photos' => Photo::where('statut_photo', 'en_attente')->count()
            ]);
        });

        View::composer('partials.sidebar', function ($view) {
            $view->with([
                'pending_agents' => \App\Models\Agent::where('statut_photo', 'en_attente')->count(),
                'validated_agents' => \App\Models\Agent::where('statut_photo', 'validee')->count(),
                'rejected_agents' => \App\Models\Agent::where('statut_photo', 'rejetee')->count(),
            ]);
        });


    }

}
