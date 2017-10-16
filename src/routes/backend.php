<?php


$router->group(['prefix' => 'admin', 'namespace' => 'Backend'], function($router){
    
    $router->get('/', function(){
        return redirect()->route("adminindex");
    });
    $router->get('/login', 'LoginController@index')->name('adminlogin');
    $router->post('/login', 'LoginController@login')->name('adminlogin');
    $router->get('/logout', 'LoginController@logout')->name('adminlogout');
    $router->get('/captcha', 'HomeController@captcha')->name('admincaptcha');
    $router->get('/success-message', 'HomeController@successMessage')->name('success-message');
    $router->get('/error-message', 'HomeController@errorMessage')->name('error-message');
    
    $router->group(['middleware'=>'auth.backend:backend'],function($router){
        $router->get('/index', ['uses'=>'HomeController@index'])->name('adminindex');
        $router->get('/dashboard', ['uses'=>'HomeController@dashboard'])->name('dashboard');
        //管理员
        $router->get('/adminlist', ['uses'=>'AdminController@index','middleware'=>'permission:admin.list'])->name('adminlist');
        $router->get('/adminadd', ['uses'=>'AdminController@add','middleware'=>'permission:admin.add'])->name('adminadd');
        $router->post('/adminstore', ['uses'=>'AdminController@store','middleware'=>'permission:admin.add'])->name('adminstore');
        $router->get('/adminedit', ['uses'=>'AdminController@edit','middleware'=>'permission:admin.edit'])->name('adminedit');
        $router->post('/adminupdate', ['uses'=>'AdminController@update','middleware'=>'permission:admin.edit'])->name('adminupdate');
        $router->post('/admindeletebatch', ['uses'=>'AdminController@deletebatch','middleware'=>'permission:admin.delete'])->name('admindeletebatch');
        //角色
        $router->get('/rolelist', ['uses'=>'RoleController@index','middleware'=>'permission:role.list'])->name('rolelist');
        $router->get('/roleadd', ['uses'=>'RoleController@add','middleware'=>'permission:role.add'])->name('roleadd');
        $router->post('/rolestore', ['uses'=>'RoleController@store','middleware'=>'permission:role.add'])->name('rolestore');
        $router->get('/roleedit', ['uses'=>'RoleController@edit','middleware'=>'permission:role.edit'])->name('roleedit');
        $router->post('/roleupdate', ['uses'=>'RoleController@update','middleware'=>'permission:role.edit'])->name('roleupdate');
        $router->post('/roledeletebatch/', ['uses'=>'RoleController@deletebatch','middleware'=>'permission:role.delete'])->name('roledeletebatch');
    });
});
