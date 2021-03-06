<?php

namespace App\Providers;

use Encore\Admin\Config\Config;
use Illuminate\Support\ServiceProvider;
use DB;
use Illuminate\Http\Resources\Json\Resource;
use GatewayClient\Gateway;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        \Carbon\Carbon::setLocale('zh');

        //模型查看器
        \App\Models\User::observe(\App\Observers\UserObserver::class);
        \App\Models\Group::observe(\App\Observers\GroupObserver::class);
/*
        DB::listen(function ($query) {
              //echo $query->sql."||||||||<br>";
            // print_r( $query->bindings);
            // $query->time
        });*/

        DB::listen(
            function ($sql) {
                foreach ($sql->bindings as $i => $binding) {
                    if ($binding instanceof \DateTime) {
                        $sql->bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                    } else {
                        if (is_string($binding)) {
                            $sql->bindings[$i] = "'$binding'";
                        }
                    }
                }
                // Insert bindings into query
                $query = str_replace(array('%', '?'), array('%%', '%s'), $sql->sql);
                $query = vsprintf($query, $sql->bindings);
                $query .= ' ---> time:'.$sql->time;
                $logFile = fopen(
                    storage_path('logs' . DIRECTORY_SEPARATOR . date('Ymd') . '_query.log'),
                    'a+'
                );
                fwrite($logFile, date('Y-m-d H:i:s') . ': ' . $query . PHP_EOL);
                fclose($logFile);
            }
        );

        Gateway::$registerAddress = '192.168.1.240:97';
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
