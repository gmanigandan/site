<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
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
        //
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
        $this->loadRoutesFrom(base_path('routes/web.php'));

        Route::middleware('web')
             ->prefix('admin')
             ->group(base_path('routes/admin.php'));

        $verticalMenuJson = file_get_contents(base_path('resources/admin-menu/verticalMenu.json'));
        $verticalMenuData = json_decode($verticalMenuJson);

        // Share all menuData to all the views
        \View::share('menuData', [$verticalMenuData]);
    }
}
