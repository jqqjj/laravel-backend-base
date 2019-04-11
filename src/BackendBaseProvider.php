<?php

namespace Jqqjj\BackendBase;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Helpers\BackendResponseMessage;
use App\Helpers\Pagination;
use App\Helpers\Documents;
use App\Helpers\Human;
use App\Helpers\Captcha;
use App\Helpers\Referer;
use App\Helpers\RequestClient;
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
			__DIR__ . "/events"=> app_path("Events"),
            __DIR__ . "/exceptions"=> app_path("Exceptions"),
            __DIR__ . "/listeners"=> app_path("Listeners"),
            __DIR__ . "/business"=> app_path("Http/Business"),
            __DIR__ . "/controllers"=> app_path("Http/Controllers"),
            __DIR__ . "/middleware"=> app_path("Http/Middleware"),
            __DIR__ . "/view-helper"=> app_path("Http/ViewHelper"),
            __DIR__ . "/model"=> app_path("Model"),
            __DIR__ . "/config"=> base_path("config"),
            __DIR__ . "/database/migrations"=> database_path("migrations"),
            __DIR__ . "/database/seeds"=> database_path("seeds"),
            __DIR__ . "/public"=> public_path("/"),
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
        $this->app->bind('captcha', function(){
            return new Captcha();
        });
        $this->app->bind('referer', function(){
            return new Referer();
        });
        $this->app->singleton('human', function(){
            return new Human();
        });
		$this->app->singleton('request_client', function(){
            return new RequestClient();
        });
        
        $this->app->singleton('viewhelper', ViewHelper::class);
    }
}
