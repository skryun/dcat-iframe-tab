<?php

namespace Mosiboom\DcatIframeTab;

use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Illuminate\Support\ServiceProvider;

class IframeTabProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //注册 Dcat的容器事件
        if (config('iframe_tab.enable')) {
            $this->app->resolving(Content::class, function ($content, $app) {
                //设置view 为 iframe.full-content
                $content->view('iframe-tab::full-content');
            });
            Content::resolving(function (Content $content) {
                //设置view 为 iframe.full-content
                $content->view('iframe-tab::full-content');
            });
            Grid::resolving(function (Grid $grid) {
                $grid->setDialogFormDimensions(config('iframe_tab.dialog_area_width'), config('iframe_tab.dialog_area_height'));
            });
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/resource/views', 'iframe-tab');
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->publishes([
            __DIR__ . '/assets/js/compress' => public_path('vendor/iframe-tab/js'),
            __DIR__ . '/assets/css' => public_path('vendor/iframe-tab/css'),
        ], 'iframe-tab');
        $this->publishes([
            __DIR__ . '/resource/views' => resource_path('views/vendor/iframe-tab'),
        ], 'iframe-tab.view');
        $this->publishes([
            __DIR__ . '/iframe_tab.php' => config_path('iframe_tab.php'),
        ], 'iframe-tab.config');
    }
}
