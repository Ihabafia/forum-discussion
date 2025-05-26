<?php

namespace App\Providers;

use App\Services\Helpers;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('fd-helpers', function ($app) {
            if (! class_exists(Helpers::class)) {
                throw new Exception('** HelpersService class not found');
            }

            return new Helpers;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
        Model::preventLazyLoading();
        Model::automaticallyEagerLoadRelationships();
        Model::unguard();
    }
}
