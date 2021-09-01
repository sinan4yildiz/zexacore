<?php

use Illuminate\Support\Facades\Route;

// Web
Route::group([
    'as'        => 'web.',
    'namespace' => 'Web',
], function () {

    Route::get('', 'HomeController@index')->name('home');

});

// Admin
Route::group([
    'as'        => 'admin.',
    'prefix'    => env('APP_ADMIN_DIR'),
    'namespace' => 'Admin',
], function () {

    Route::get('/{any?}', 'AppController@index')->where('any', '.*')->name('dashboard');

});
