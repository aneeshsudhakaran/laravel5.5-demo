<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['guest']], function () {
    
    Route::get('/', function () {
        return view('welcome');
    });
        
    Route::get('/home', function () {
        return view('welcome');
    });
    
    
    
    // ADMIN
    Route::get('admin/login', 'backend\Auth\LoginController@getLoginForm')->name('admin.login');
    Route::post('admin/authenticate', 'backend\Auth\LoginController@authenticate')->name('admin.authenticate');
    
    Route::get('admin/register', 'backend\Auth\RegisterController@getRegisterForm')->name('admin.register');
    Route::post('admin/saveregister', 'backend\Auth\RegisterController@saveRegisterForm')->name('admin.saveregister');
    
    // ADMIN Password Reset Routes...
    $this->post('admin/password/email', 'backend\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    $this->get('admin/password/reset', 'backend\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    $this->post('admin/password/reset', 'backend\Auth\ResetPasswordController@reset');
    $this->get('admin/password/reset/{token}', 'backend\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
    
     // USER
    Route::get('user/login', 'frontend\Auth\LoginController@getLoginForm')->name('user.login');
    Route::post('user/authenticate', 'frontend\Auth\LoginController@authenticate')->name('user.authenticate');
    
    Route::get('user/register', 'frontend\Auth\RegisterController@getRegisterForm')->name('user.register');
    Route::post('user/saveregister', 'frontend\Auth\RegisterController@saveRegisterForm')->name('user.saveregister');
            
    // USER Password Reset Routes...
    $this->post('user/password/email', 'frontend\Auth\ForgotPasswordController@sendResetLinkEmail')->name('user.password.email');
    $this->get('user/password/reset', 'frontend\Auth\ForgotPasswordController@showLinkRequestForm')->name('user.password.request');
    $this->post('user/password/reset', 'frontend\Auth\ResetPasswordController@reset')->name('user.password.reset');
    $this->get('user/password/reset/{token}', 'frontend\Auth\ResetPasswordController@showResetForm')->name('user.password.reset');
    
    
});



Route::group(['middleware' => ['user']], function () {
    
    Route::post('user/logout', 'frontend\Auth\LoginController@getLogout')->name('user.logout');
    Route::get('user/dashboard', 'frontend\UserController@dashboard')->name('user.dashboard');
    
    
});


Route::group(['middleware' => ['admin']], function () { 
    
    Route::get('admin/dashboard', 'backend\AdminController@dashboard')->name('admin.dashboard');
    Route::post('admin/logout', 'backend\Auth\LoginController@getLogout')->name('admin.logout'); 
    
});

