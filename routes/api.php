<?php

use Illuminate\Support\Facades\Route;

// API
Route::group([
    'as'         => 'api.',
    'middleware' => 'auth:api',
    'namespace'  => 'Api\v1',
], function () {

    // Pages
    Route::group([
        'as'        => 'pages',
        'prefix'    => 'pages',
        'namespace' => 'Content',
    ], function () {
        Route::get('/', 'PageController@index')->name('index');
        Route::post('/create', 'PageController@create')->name('create');
        Route::put('/update/{id}', 'PageController@update')->name('update');
        Route::patch('/activate/{id}', 'PageController@activate')->name('activate');
        Route::patch('/deactivate/{id}', 'PageController@deactivate')->name('deactivate');
        Route::delete('/remove/{id}', 'PageController@remove')->name('remove');
    });

    // Uploads
    Route::group([
        'as'        => 'uploads',
        'prefix'    => 'uploads',
        'namespace' => 'Content',
    ], function () {
        Route::get('/', 'UploadController@index')->name('index');
        Route::post('/upload-file', 'UploadController@uploadFile')->name('upload_file');
        Route::post('/create-folder', 'UploadController@createFolder')->name('create_folder');
        Route::delete('/remove', 'UploadController@remove')->name('remove');
    });

    // Categories
    Route::group([
        'as'        => 'categories',
        'prefix'    => 'categories',
        'namespace' => 'Structure',
    ], function () {
        Route::get('/', 'CategoryController@index')->name('index');
        Route::get('/{id}', 'CategoryController@single')->name('single')->where('id', '[0-9]+');;
        Route::get('/parent/{id}', 'CategoryController@parent')->name('parent');
        Route::post('/create', 'CategoryController@create')->name('create');
        Route::put('/update/{id}', 'CategoryController@update')->name('update');
        Route::get('/autocomplete', 'CategoryController@autocomplete')->name('autocomplete');
        Route::patch('/order', 'CategoryController@order')->name('order');
        Route::patch('/activate/{id}', 'CategoryController@activate')->name('activate');
        Route::patch('/deactivate/{id}', 'CategoryController@deactivate')->name('deactivate');
        Route::delete('/remove/{id}', 'CategoryController@remove')->name('remove');
    });

    // Content types
    Route::group([
        'as'        => 'content_types',
        'prefix'    => 'content-types',
        'namespace' => 'Structure',
    ], function () {
        Route::get('/', 'ContentTypeController@index')->name('index');
        Route::get('/{id}', 'ContentTypeController@single')->name('single')->where('id', '[0-9]+');
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

    // Redirections
    Route::group([
        'as'        => 'redirections',
        'prefix'    => 'redirections',
        'namespace' => 'Tools',
    ], function () {
        Route::get('/', 'RedirectionController@index')->name('index');
        Route::post('/create', 'RedirectionController@create')->name('create');
        Route::put('/update/{id}', 'RedirectionController@update')->name('update');
        Route::delete('/remove/{id}', 'RedirectionController@remove')->name('remove');
    });

    // Slugs
    Route::group([
        'as'        => 'slugs',
        'prefix'    => 'slugs',
        'namespace' => 'Tools',
    ], function () {
        Route::get('/', 'SlugController@index')->name('index');
        Route::put('/update/{id}', 'SlugController@update')->name('update');
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