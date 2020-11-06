<?php

use Illuminate\Support\Facades\Route;

// API
Route::group([
    'as'         => 'api.',
    'middleware' => 'auth:api',
], function () {

    // Users
    Route::group([
        'as'     => 'users',
        'prefix' => 'users',
    ], function () {

        Route::get('/', 'Api\v1\People\UserController@index')->name('index');

    });
});