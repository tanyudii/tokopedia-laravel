<?php

namespace tanyudii\Laratok;

use Illuminate\Support\ServiceProvider;
use tanyudii\Laratok\Services\Tokopedia\Campaign;
use tanyudii\Laratok\Services\Tokopedia\Category;
use tanyudii\Laratok\Services\Tokopedia\Encryption;
use tanyudii\Laratok\Services\Tokopedia\Finance;
use tanyudii\Laratok\Services\Tokopedia\Interaction;
use tanyudii\Laratok\Services\Tokopedia\Logistic;
use tanyudii\Laratok\Services\Tokopedia\Order;
use tanyudii\Laratok\Services\Tokopedia\Product;
use tanyudii\Laratok\Services\Tokopedia\Shop;
use tanyudii\Laratok\Services\Tokopedia\Statistic;
use tanyudii\Laratok\Services\Tokopedia\Webhooks;

class LaratokServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerTokopediaService();

        $this->mergeConfigFrom(__DIR__ . "/../assets/laratok.php", "laratok");
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    __DIR__ . "/../assets/laratok.php" => $this->app->configPath(
                        "laratok.php"
                    ),
                ],
                "laratok-config"
            );
        }
    }

    /**
     * Register tokopedia services
     */
    protected function registerTokopediaService()
    {
        $this->app->bind("laratok-campaign-service", function () {
            return $this->app->make(Campaign::class);
        });

        $this->app->bind("laratok-category-service", function () {
            return $this->app->make(Category::class);
        });

        $this->app->bind("laratok-encryption-service", function () {
            return $this->app->make(Encryption::class);
        });

        $this->app->bind("laratok-finance-service", function () {
            return $this->app->make(Finance::class);
        });

        $this->app->bind("laratok-interaction-service", function () {
            return $this->app->make(Interaction::class);
        });

        $this->app->bind("laratok-logistic-service", function () {
            return $this->app->make(Logistic::class);
        });

        $this->app->bind("laratok-order-service", function () {
            return $this->app->make(Order::class);
        });

        $this->app->bind("laratok-product-service", function () {
            return $this->app->make(Product::class);
        });

        $this->app->bind("laratok-shop-service", function () {
            return $this->app->make(Shop::class);
        });

        $this->app->bind("laratok-statistic-service", function () {
            return $this->app->make(Statistic::class);
        });

        $this->app->bind("laratok-webhooks-service", function () {
            return $this->app->make(Webhooks::class);
        });
    }
}
