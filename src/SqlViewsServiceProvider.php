<?php namespace CodeZero\LaravelSqlViews;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class SqlViewsServiceProvider extends LaravelServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {

        $this->handleConfigs();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {

        // Bind any implementations.

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {

        return [];
    }

    private function handleConfigs() {

        $configPath = __DIR__ . '/../config/sql-views.php';

        $this->publishes([$configPath => config_path('sql-views.php')]);

        $this->mergeConfigFrom($configPath, 'sql-views');
    }

}
