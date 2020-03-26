<?php

namespace LimeDeck\NovaCashierOverview\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class CashierOverviewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public static $name = 'nova-cashier-overview';

    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });

        // dd(resource_path('lang/vendor/' . static::$name));
        $this->publishes([
            __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/' . static::$name),
        ]);

        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-cashier-overview', __DIR__ . '/../../dist/js/tool.js');
            Nova::translations(static::getTranslations());
        });
    }

    private static function getTranslations(): array
    {
        $translationFile = resource_path('lang/vendor/' . static::$name . '/' . app()->getLocale() . '.json');

        if (!is_readable($translationFile)) {
            $translationFile = __DIR__ . '/../resources/lang/' . app()->getLocale() . '.json';

            if (!is_readable($translationFile)) {
                return [];
            }
        }

        return json_decode(file_get_contents($translationFile), true);
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova'])
            ->namespace('LimeDeck\NovaCashierOverview\Http\Controllers')
            ->prefix('nova-vendor/nova-cashier-overview')
            ->group(__DIR__ . '/../../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
