<?php

namespace App\Providers;

use App\Providers\Filament\AdminPanelProvider;
use Illuminate\Support\ServiceProvider;
use App\Filament\Resources\KurirResource;

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
        $this->app->register(AdminPanelProvider::class);
    }
}
