<?php

use Illuminate\Support\Facades\Route;

/*
 * API Routes
 *
 * */
Route::group([
    'as'        => 'api.',
    'namespace' => 'Api\v1',
], function () {

    /*
     * Unuthenticated routes
     *
     * */
    Route::group([
    ], function () {

        // Auth
        Route::group([
            'as'        => 'auth.',
            'prefix'    => 'auth',
            'namespace' => 'Auth',
        ], function () {
            Route::post('/login', 'AuthController@login')->name('login');
            Route::post('/logout', 'AuthController@logout')->name('logout');
            Route::post('/verify', 'AuthController@verify')->name('verify');
        });
    });


    /*
     * Authenticated routes
     *
     * */
    Route::group([
        'middleware' => 'auth:api',
    ], function () {

        // Search
        Route::get('/search', 'SearchController@index')->name('search');

        // Dashboard
        Route::group([
            'as'     => 'dashboard.',
            'prefix' => 'dashboard',
        ], function () {
            Route::get('/reports', 'DashboardController@reports')->name('reports');
            Route::get('/statistics', 'DashboardController@statistics')->name('statistics');
            Route::get('/counts', 'DashboardController@counts')->name('counts');
        });

        // Articles
        Route::group([
            'as'        => 'articles.',
            'prefix'    => 'articles',
            'namespace' => 'Content',
        ], function () {
            Route::get('/', 'ArticleController@index')->name('index');
            Route::get('/{id}', 'ArticleController@single')->name('single')->where('id', '[0-9]+');
            Route::post('/create', 'ArticleController@create')->name('create');
            Route::put('/update/{id}', 'ArticleController@update')->name('update');
            Route::get('/autocomplete', 'ArticleController@autocomplete')->name('autocomplete');
            Route::patch('/activate/{id}', 'ArticleController@activate')->name('activate');
            Route::patch('/deactivate/{id}', 'ArticleController@deactivate')->name('deactivate');
            Route::delete('/remove/{id}', 'ArticleController@remove')->name('remove');
        });

        // Pages
        Route::group([
            'as'        => 'pages.',
            'prefix'    => 'pages',
            'namespace' => 'Content',
        ], function () {
            Route::get('/', 'PageController@index')->name('index');
            Route::get('/{id}', 'PageController@single')->name('single')->where('id', '[0-9]+');
            Route::post('/create', 'PageController@create')->name('create');
            Route::put('/update/{id}', 'PageController@update')->name('update');
            Route::get('/autocomplete', 'PageController@autocomplete')->name('autocomplete');
            Route::patch('/activate/{id}', 'PageController@activate')->name('activate');
            Route::patch('/deactivate/{id}', 'PageController@deactivate')->name('deactivate');
            Route::delete('/remove/{id}', 'PageController@remove')->name('remove');
        });

        // Uploads
        Route::group([
            'as'        => 'uploads.',
            'prefix'    => 'uploads',
            'namespace' => 'Content',
        ], function () {
            Route::get('/', 'UploadController@index')->name('index');
            Route::post('/upload-file', 'UploadController@uploadFile')->name('upload_file');
            Route::post('/create-folder', 'UploadController@createFolder')->name('create_folder');
            Route::delete('/remove', 'UploadController@remove')->name('remove');
        });

        // Messages
        Route::group([
            'as'     => 'messages.',
            'prefix' => 'messages',
        ], function () {
            Route::get('/', 'MessageController@index')->name('index');
            Route::patch('/mark-as-read/{id}', 'MessageController@markAsRead')->name('read');
            Route::patch('/mark-as-unread/{id}', 'MessageController@markAsUnread')->name('unread');
            Route::delete('/remove/{id}', 'MessageController@remove')->name('remove');
        });

        // Categories
        Route::group([
            'as'        => 'categories.',
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
            'as'        => 'content_types.',
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
            'as'        => 'users.',
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
            'as'        => 'activities.',
            'prefix'    => 'activities',
            'namespace' => 'People',
        ], function () {
            Route::get('/', 'ActivityController@index')->name('index');
        });

        // Redirections
        Route::group([
            'as'        => 'redirections.',
            'prefix'    => 'redirections',
            'namespace' => 'Tools',
        ], function () {
            Route::get('/', 'RedirectionController@index')->name('index');
            Route::post('/create', 'RedirectionController@create')->name('create');
            Route::put('/update/{id}', 'RedirectionController@update')->name('update');
            Route::delete('/remove/{id}', 'RedirectionController@remove')->name('remove');
        });

        // Not founds
        Route::group([
            'as'        => 'not_founds.',
            'prefix'    => 'not-founds',
            'namespace' => 'Tools',
        ], function () {
            Route::get('/', 'NotFoundController@index')->name('index');
            Route::delete('/remove/{id}', 'NotFoundController@remove')->name('remove');
        });

        // Slugs
        Route::group([
            'as'        => 'slugs.',
            'prefix'    => 'slugs',
            'namespace' => 'Tools',
        ], function () {
            Route::get('/', 'SlugController@index')->name('index');
            Route::put('/update/{id}', 'SlugController@update')->name('update');
        });

        // Languages
        Route::group([
            'as'        => 'languages.',
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
            'as'        => 'settings.',
            'prefix'    => 'settings',
            'namespace' => 'System',
        ], function () {
            Route::get('/', 'SettingController@index')->name('index');
            Route::put('/update', 'SettingController@update')->name('update');
        });

        // Maintenance
        Route::group([
            'as'        => 'maintenance.',
            'prefix'    => 'maintenance',
            'namespace' => 'System\Maintenance',
        ], function () {

            // Clear cache
            Route::post('/clear-cache', 'MaintenanceController@clearCache')->name('clear_cache');

            // Backup
            Route::group([
                'as'     => 'backup.',
                'prefix' => 'backup',
            ], function () {
                Route::get('/', 'BackupController@index')->name('index');
                Route::post('/create', 'BackupController@create')->name('create');
                Route::put('/restore/{name}', 'BackupController@restore')->name('restore');
                Route::delete('/remove/{name}', 'BackupController@remove')->name('remove');
            });

            // Logs
            Route::group([
                'as'     => 'logs.',
                'prefix' => 'logs',
            ], function () {
                Route::get('/', 'LogController@index')->name('index');
                Route::post('/write', 'LogController@write')->name('write');
            });
        });
    });
});