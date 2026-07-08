<?php

namespace App\Providers;

use App\Core\Repositories\Contracts\TicketRepositoryInterface;
use App\Core\Repositories\TicketRepository;
use App\Models\asset;
use App\Models\AssetAssignment;
use App\Observers\AssetAssignmentObserver;
use App\Observers\AssetObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\AliasLoader;
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
        $this->app->bind(
            TicketRepositoryInterface::class,
            TicketRepository::class,
        );
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
            'ticket' => 'App\Models\Ticket',
        ]);
        $loader = AliasLoader::getInstance();
        $loader->alias('Excel', \Maatwebsite\Excel\Facades\Excel::class);
    }
}
