<?php namespace Infusionsoft\FrameworkSupport\Laravel;

use Illuminate\Support\ServiceProvider;
use Infusionsoft\Infusionsoft;

class InfusionsoftServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $config = __DIR__ . '/config/config.php';
        $this->mergeConfigFrom($config, 'infusionsoft');
        $this->publishes([$config => config_path('infusionsoft.php')]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('infusionsoft', function ($app) {

            return new Infusionsoft(config('infusionsoft'));

        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('infusionsoft');
    }

}