<?php

namespace App\Providers;

use App\Models\asset;
use App\Models\AssetAssignment;
use App\Observers\AssetAssignmentObserver;
use App\Observers\AssetObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        AssetAssignment::observe(AssetAssignmentObserver::class);
        asset::observe(AssetObserver::class);
        Relation::morphMap([
            'ticket'  => 'App\Models\Ticket',
        ]);
    }
}
