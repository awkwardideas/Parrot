<?php namespace AwkwardIdeas\Parrot;

use Illuminate\Support\ServiceProvider;

class ParrotServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/parrot.php';

        $this->publishes([$configPath => $this->getConfigPath()], 'config');

        Directive::AddCustomDirectives();

        $this->app->singleton('parrot.model', function ($app) {
            return new ParrotModel($app);
        });

        $this->app->alias('parrot.model', 'AwkwardIdeas\Parrot\ParrotModel');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Get argument array from argument string.
     *
     * @param string $argumentString
     *
     * @return array
     */
    private function getArguments($argumentString)
    {
        return explode(', ', str_replace(['(', ')'], '', $argumentString));
    }

    private function getConfigPath()
    {
        return config_path('parrot.php');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('parrot.model');
    }
}