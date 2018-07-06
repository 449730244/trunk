<?php

namespace App\Providers;

use Encore\Admin\Config\Config;
use Illuminate\Support\ServiceProvider;
use DB;
use Illuminate\Http\Resources\Json\Resource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Config::load();  // 加上这一行

       // Resource::withoutWrapping(); //禁用顶层资源的包裹

        DB::listen(function ($query) {
              //echo $query->sql."||||||||<br>";
            // print_r( $query->bindings);
            // $query->time
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
