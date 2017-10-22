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
        return view('frontend.home');
    });
        
   
    
    
    // ADMIN
    Route::get('admin/login', 'backend\Auth\LoginController@getLoginForm')->name('admin.login');
    Route::post('admin/authenticate', 'backend\Auth\LoginController@authenticate')->name('admin.authenticate');
    
    Route::get('admin/register', 'backend\Auth\RegisterController@getRegisterForm')->name('admin.register');
    Route::post('admin/saveregister', 'backend\Auth\RegisterController@saveRegisterForm')->name('admin.saveregister');
    
    // USER
    Route::get('user/login', 'frontend\Auth\LoginController@getLoginForm')->name('user.login');
    Route::post('user/authenticate', 'frontend\Auth\LoginController@authenticate')->name('user.authenticate');
    
    Route::get('user/register', 'frontend\Auth\RegisterController@getRegisterForm')->name('user.register');
    Route::post('user/saveregister', 'frontend\Auth\RegisterController@saveRegisterForm')->name('user.saveregister');
            
            
});



Route::group(['middleware' => ['user']], function () {
    
    Route::post('user/logout', 'frontend\Auth\LoginController@getLogout')->name('user.logout');
    Route::get('user/dashboard', 'frontend\UserController@dashboard')->name('user.dashboard');
    
    
});


Route::group(['middleware' => ['admin']], function () { 
    
    Route::get('admin/dashboard', 'backend\AdminController@dashboard')->name('admin.dashboard');
    Route::post('admin/logout', 'backend\Auth\LoginController@getLogout')->name('admin.logout'); 
    
});

