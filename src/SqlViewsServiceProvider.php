<?php
namespace CodeZero\LaravelSqlViews;

use CodeZero\LaravelSqlViews\Commands\DropViewsCommand;
use CodeZero\LaravelSqlViews\Commands\GenerateViewMigrationCommand;
use CodeZero\LaravelSqlViews\Commands\MigrateViewsCommand;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class SqlViewsServiceProvider extends LaravelServiceProvider
{

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton('command.codezero.view.make', function ($app) {
            return $app[GenerateViewMigrationCommand::class];
        });

        $this->commands('command.codezero.view.make');

        $this->app->singleton('command.codezero.view.migrate', function ($app) {
            return $app[MigrateViewsCommand::class];
        });

        $this->commands('command.codezero.view.migrate');

        $this->app->singleton('command.codezero.view.drop', function ($app) {
            return $app[DropViewsCommand::class];
        });

        $this->commands('command.codezero.view.drop');

    }

}
