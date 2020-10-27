<?php

use Illuminate\Support\Facades\Route;


// Admin
Route::group([
    'as'        => 'admin.',
    'prefix'    => env('APP_ADMIN_DIR'),
    'namespace' => 'Admin',
], function () {

    // Unauthorized
    Route::group([
        'as' => 'auth.',
        /*'middleware' => 'admin.unauthorized'*/
    ], function () {
        // Login
        Route::get('login', 'Auth\Login@index')->name('login');
        Route::post('login', 'Auth\Login@attempt')->name('attempt');

        // Forgotten password
        Route::match(['get', 'post'], 'forgotten-password', 'Auth\ForgottenPassword@index')->name('forgotten_password');
    });

    // Authorized
    Route::group([
        'middleware' => ['auth']
    ], function () {

        // Application
        Route::get('/{any?}', 'AppController@index')->where('any', '.*');

    });
});


// Web
Route::group([
    'as'        => 'web.',
    'namespace' => 'Web',
], function () {
    Route::get('/', 'Home@index')->name('home');

    Route::get('{slug}', function ($slug) {
        return app()->call('App\Http\Controllers\Web\Home', [], 'index');
    })->where('slug', '[^?]*');
});