<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Registry\FeatureRegistry;
use App\Feature;

class FeatureServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $features = Feature::get();
        foreach($features as $feature) {
            $this->app->make('features')->register($feature->prefix, $feature);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('features', FeatureRegistry::class);
    }
}
