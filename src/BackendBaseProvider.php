<?php

namespace Jqqjj\BackendBase;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Helpers\BackendResponseMessage;
use App\Helpers\Pagination;
use App\Helpers\Documents;
use App\Http\ViewHelper\Base\ViewHelper;

class BackendBaseProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . "/facades"=> app_path("Facades"),
            __DIR__ . "/helpers"=> app_path("Helpers"),
            __DIR__ . "/business"=> app_path("Http/Business"),
            __DIR__ . "/controllers"=> app_path("Http/Controllers"),
            __DIR__ . "/middleware"=> app_path("Http/Middleware"),
            __DIR__ . "/view-helper"=> app_path("Http/ViewHelper"),
            __DIR__ . "/model"=> app_path("Model"),
            __DIR__ . "/config"=> base_path("config"),
            __DIR__ . "/database/migrations"=> database_path("migrations"),
            __DIR__ . "/database/seeds"=> database_path("seeds"),
            __DIR__ . "/public/css"=> public_path("css"),
            __DIR__ . "/public/js"=> public_path("js"),
            __DIR__ . "/public/images"=> public_path("images"),
            __DIR__ . "/views"=> resource_path("views"),
            __DIR__ . "/routes"=> base_path("routes"),
        ]);
        
        Blade::directive('permission', function($expression){
            return "<?php if(Auth::guard('backend')->check() && Auth::guard('backend')->user()->hasPermission({$expression})): ?>";
        });
        Blade::directive('endpermission', function(){
            return "<?php endif; ?>";
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('backend_response_message', function(){
            return new BackendResponseMessage();
        });
        $this->app->bind('pagination', function(){
            return new Pagination();
        });
        $this->app->bind('documents', function(){
            return new Documents();
        });
        
        $this->app->singleton('viewhelper', ViewHelper::class);
    }
}
