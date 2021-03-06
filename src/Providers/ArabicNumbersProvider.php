<?php
/**
 * Copyright MyTh
 * Website: https://4MyTh.com
 * Email: mythpe@gmail.com
 * Copyright © 2006-2020 MyTh All rights reserved.
 */

namespace Watheq\Support\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Watheq\Support\Middlewares\ArToEnMiddleware;

/**
 * Class ArabicNumbersProvider
 * @package Watheq\Support\Providers
 */
class ArabicNumbersProvider extends ServiceProvider{

    /** @var array Config data */
    protected $configData = [
        'path' => __DIR__.'/../../config/arabic-numbers.php',
        'key'  => "arabic-numbers",
    ];

    /**
     * Register services.
     * @return void
     */
    public function register(){
        $this->mergeConfigFrom($this->configData['path'], $this->configData['key']);
    }

    /**
     * Bootstrap services.
     * @param Router $router
     * @return void
     */
    public function boot(Router $router){
        $this->publishes([$this->configData['path'] => config_path("{$this->configData['key']}.php")], 'config');
        $config = $this->app['config']->get($this->configData['key']);
        $router->aliasMiddleware(
            "myth.{$config['middleware_name']}",
            ArToEnMiddleware::class
        );
    }

    /**
     * @return array
     */
    public function provides(){
        return [$this->configData['key']];
    }
}
