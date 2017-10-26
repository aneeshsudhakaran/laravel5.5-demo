# laravel5.5-demo
Laravel 5.5 Multiauth Demo
```
# Configurations:

# /config/auth.php
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
	'user' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
	'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Model\frontend\User::class,
        ],
	'admins' => [
            'driver' => 'eloquent',
            'model' => App\Model\backend\Admin::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
	'admins' => [
            'provider' => 'admins',
            'table' => 'admins_password_resets',
            'expire' => 60,
        ],
    ],

];

# routes/web.php

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



# app/Http/Kernel.php
Add with protected $routeMiddleware = [

	      + 'admin' => \App\Http\Middleware\CheckAdmin::class,
        + 'user' => \App\Http\Middleware\CheckUser::class,

#/app/Http/Middleware

CheckAdmin.php ->> For check admin 

CheckUser.php  ->> For check user



# Migration Tables
## /database/migrations

2014_10_12_000000_create_users_table.php

2014_10_12_100000_create_users_password_resets_table.php

2016_10_18_131257_create_admins_table.php

2016_10_18_131630_create_admins_passowrd_resets_table.php


# Import Tables : 

Excecute

php artisan migrate
```
