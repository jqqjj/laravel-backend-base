# laravel-backend-base

### Installation
Run the following to include this via Composer
```php
composer require jqqjj/laravel-backend-base
```
### Configuration
Register the ServiceProvider to the providers array in config/app.php
```php
Jqqjj\BackendBase\BackendBaseProvider::class,
```
Publish files
```php
php artisan vendor:publish --provider="Jqqjj\BackendBase\BackendBaseProvider" --force
```
Run migrations
```php
php artisan migrate
```
Composer dump-autoload
```php
composer dump-autoload
```
Seed database data
```php
php artisan db:seed --class=RbacSeeder
```
Register Facade to the aliases array in config/app.php
```php
'ViewHelper' => App\Facades\ViewHelper::class,
'Referer' => App\Facades\Referer::class,
```
Register Middleware to the routeMiddleware array in app/Http/Kernel.php
```php
'auth.backend' => \App\Http\Middleware\AuthBackend::class,
'permission' => \App\Http\Middleware\Permission::class,
```
Register Event to the listen array in app/Providers/EventServiceProvider.php
```php
'Illuminate\Auth\Events\Login'=>[
    'App\Listeners\BacknedLoginListener',
],
```
Add one more guard to the guards array in config/auth.php
```php
'backend' => [
    'driver' => 'session',
    'provider' => 'backend',
],
```
Add another provider to providers array in config/auth.php
```php
'backend' => [
    'driver' => 'eloquent',
    'model' => App\Model\Admin::class,
],
```
Load routes in function mapWebRoutes in file app/Providers/RouteServiceProvider.php
```php
Route::group([
    'middleware' => 'web',
    'namespace' => $this->namespace,
],function($router){
    require base_path('routes/backend.php');
});
```
Others: time zones setting,session setting(expire_on_close),key generate
### Inspection
backend url: yourdomain/admin/  
login name:admin  
login password:admin
### License
This package is licensed under the [MIT license](http://opensource.org/licenses/MIT).
