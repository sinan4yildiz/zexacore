<?php

use Illuminate\Support\Facades\Route;

// API
Route::group([
    'as'         => 'api.',
    'middleware' => 'auth:api',
    'namespace'  => 'Api\v1',
], function () {

    // Users
    Route::group([
        'as'        => 'users',
        'prefix'    => 'users',
        'namespace' => 'People',
    ], function () {

        Route::get('/', 'UserController@index')->name('index');
        Route::post('/create', 'UserController@create')->name('create');
        Route::put('/update/{id}', 'UserController@update')->name('update');
        Route::patch('/activate/{id}', 'UserController@activate')->name('activate');
        Route::patch('/deactivate/{id}', 'UserController@deactivate')->name('deactivate');
        Route::delete('/remove/{id}', 'UserController@remove')->name('remove');

    });
});