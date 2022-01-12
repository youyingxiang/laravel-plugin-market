<?php

namespace Yxx\LaravelPluginMarket\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PluginMarketServiceProvider extends ServiceProvider
{
    /**
     * @var string $pluginNameLower
     */
    protected string $pluginNameLower = 'pluginmarket';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();
        $this->registerViews();
        $this->registerPublishing();
        $this->gate();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', $this->pluginNameLower);
        $this->registerAuthConfig();
        $this->app->register(RouteServiceProvider::class);
    }

    private function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/config.php' => config_path($this->pluginNameLower . ".php"),
            ], 'plugin-market-config');
            $this->publishes([
                __DIR__.'/../../resources/lang' => resource_path('lang'),
            ], 'plugin-market-lang');

            // 是否开启 ui
            if (config('pluginmarket.ui.enable')) {
                $this->publishes([
                    __DIR__.'/../../resources/build' => public_path('vendor/'. $this->pluginNameLower)
                ], $this->pluginNameLower . '-build');
            }

            $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        }
    }
    /**
     * Register auth config.
     *
     * @return void
     */
    protected function registerAuthConfig()
    {
        config(Arr::dot(config($this->pluginNameLower . '.auth', []), 'auth.'));
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', $this->pluginNameLower);
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    protected function gate(): void
    {
        Gate::define('viewPluginMarket', function ($user) {
            return in_array($user->email, config("$this->pluginNameLower.allow_view_admin"));
        });
    }
}
