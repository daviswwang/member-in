<?php
/**
 * Created by PhpStorm.
 * User: fanxinyu
 * Date: 2020-11-11
 * Time: 11:04
 */

namespace Daviswwang\MemberIn;

use Illuminate\Support\ServiceProvider;

class MemberInServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(MemberIn::class, function () {
            return new MemberIn([config('elasticSearch.hosts'), config('elasticSearch.index')]);
        });

        $this->app->alias(MemberIn::class, 'memberin');
    }

    public function provides()
    {
        return [MemberIn::class, 'memberin'];
    }

    public function boot()
    {
        $path = realpath(__DIR__ . '/Config/config.php');

        $this->publishes([$path => config_path('elasticSearch.php')], 'config');
        $this->mergeConfigFrom($path, 'memberin');
    }

}