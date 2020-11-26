<?php

use Illuminate\Support\Facades\Route;

// API
Route::group([
    'as'         => 'api.',
    'middleware' => 'auth:api',
    'namespace'  => 'Api\v1',
], function () {

    // Content types
    Route::group([
        'as'        => 'content_types',
        'prefix'    => 'content-types',
        'namespace' => 'Structure',
    ], function () {
        Route::get('/', 'ContentTypeController@index')->name('index');
        Route::post('/create', 'ContentTypeController@create')->name('create');
        Route::put('/update/{id}', 'ContentTypeController@update')->name('update');
        Route::patch('/order', 'ContentTypeController@order')->name('order');
        Route::patch('/activate/{id}', 'ContentTypeController@activate')->name('activate');
        Route::patch('/deactivate/{id}', 'ContentTypeController@deactivate')->name('deactivate');
        Route::delete('/remove/{id}', 'ContentTypeController@remove')->name('remove');
    });

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

    // Activities
    Route::group([
        'as'        => 'activities',
        'prefix'    => 'activities',
        'namespace' => 'People',
    ], function () {
        Route::get('/', 'ActivityController@index')->name('index');
    });

    // Languages
    Route::group([
        'as'        => 'languages',
        'prefix'    => 'languages',
        'namespace' => 'System',
    ], function () {
        Route::get('/', 'LanguageController@index')->name('index');
        Route::post('/create', 'LanguageController@create')->name('create');
        Route::put('/update/{id}', 'LanguageController@update')->name('update');
        Route::patch('/order', 'LanguageController@order')->name('order');
        Route::patch('/activate/{id}', 'LanguageController@activate')->name('activate');
        Route::patch('/deactivate/{id}', 'LanguageController@deactivate')->name('deactivate');
        Route::delete('/remove/{id}', 'LanguageController@remove')->name('remove');
    });

    // Settings
    Route::group([
        'as'        => 'settings',
        'prefix'    => 'settings',
        'namespace' => 'System',
    ], function () {
        Route::get('/', 'SettingController@index')->name('index');
        Route::put('/update', 'SettingController@update')->name('update');
    });
});