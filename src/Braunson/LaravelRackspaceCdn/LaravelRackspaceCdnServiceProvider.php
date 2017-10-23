<?php namespace Braunson\LaravelRackspaceCdn;

use Illuminate\Support\ServiceProvider;
use Braunson\LaravelRackspaceCdn\Commands;
use Braunson\LaravelRackspaceCdn\LaravelVersion as Version;
use Braunson\LaravelRackspaceCdn\Exceptions\IncorrectAppVersionException;

class LaravelRackspaceCdnServiceProvider extends ServiceProvider {

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
	    $version = new Version();

        if ($version->compare('5.0', '>=')) {

            $this->publishConfig();

        } else {

            // package() removed in Laravel 5.0+
            $this->package('braunson/laravel-rackspace-cdn');

        }
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        // TODO Change 'open-cloud' to class constant (Contracts\OpenCloud::class) in Laravel 5.2+
        $this->app->singleton('open-cloud', function ($app)
        {
            return new OpenCloud;
        });

        $this->app->singleton('cdn.sync', function ($app)
        {
            return new Commands\CdnSyncCommand;
        });

        $routes = $this->app['router']->getRoutes();
        $request = $this->app['request'];

        $this->app->bind('url', function() use ($routes, $request)
        {
            return new UrlGenerator($routes, $request);
        });

        $this->commands('cdn.sync');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}


    /**
     * Register config path to be published by the 'artisan vendor:publish' command
     *
     * @throws IncorrectAppVersionException
     * @return void
     */
    protected function publishConfig()
    {
        $version = new Version();

        if ($version->compare('5.0', '<')){
            throw new IncorrectAppVersionException();
        }

        $configPath = __DIR__ . '/../../config/config.php';

        if (function_exists('config_path')) {
            $publishPath = config_path('laravel-rackspace-cdn.php');
        } else {
            $publishPath = base_path('config/laravel-rackspace-cdn.php');
        }

        $this->publishes([$configPath => $publishPath], 'config');

    }

}
