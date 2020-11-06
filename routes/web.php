<?php

use Illuminate\Support\Facades\Route;

// Admin
Route::group([
    'as'        => 'admin.',
    'prefix'    => env('APP_ADMIN_DIR'),
    'namespace' => 'Admin',
], function () {

    // Unauthorized
    Auth::routes(['register' => false]);

    // Authorized
    Route::group([
        'middleware' => ['auth']
    ], function () {

        // Application
        Route::get('/{any?}', 'AppController@index')->where('any', '.*')->name('dashboard');

    });
});
