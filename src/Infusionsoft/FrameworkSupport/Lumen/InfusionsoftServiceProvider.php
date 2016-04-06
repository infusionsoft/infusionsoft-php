<?php namespace Infusionsoft\FrameworkSupport\Lumen;

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

	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('infusionsoft', function ($app) {

			$config = [
				'clientId' => env('INFUSIONSOFT_CLIENT_ID'),
				'clientSecret' => env('INFUSIONSOFT_SECRET'),
				'redirectUri' => env('INFUSIONSOFT_REDIRECT_URL'),
			];

			return new Infusionsoft($config);

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
