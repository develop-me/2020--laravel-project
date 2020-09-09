<?php

Route::get('/', "Articles@index");
Route::get('/search', "Articles@search");

Route::group(["prefix" => "articles"], function () {
    // put behind the auth route
    // need to be logged in to use
    // /create needs to come before /{article}
    Route::group(["middleware" => "auth"], function () {
        Route::get('create', "Articles@create");
        Route::post('create', "Articles@createPost");
        Route::get('{article}/edit', "Articles@edit");
        Route::post('{article}/edit', "Articles@editPost");
    });

    // /{article} needs to come after /create
    Route::get('{article}', "Articles@show");
    Route::post('{article}', "Articles@commentPost");
});

Auth::routes(['register' => false]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
