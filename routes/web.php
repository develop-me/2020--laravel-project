<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Articles;

Route::get('/', [Articles::class, "index"]);
Route::get('/search', [Articles::class, "search"]);

Route::group(["prefix" => "articles"], function () {
    // put behind the auth route
    // need to be logged in to use
    // /create needs to come before /{article}
    Route::group(["middleware" => "auth"], function () {
        Route::get('create', [Articles::class, "create"]);
        Route::post('create', [Articles::class, "createPost"]);
        Route::get('{article}/edit', [Articles::class, "edit"]);
        Route::post('{article}/edit', [Articles::class, "editPost"]);
    });

    // /{article} needs to come after /create
    Route::get('{article}', [Articles::class, "show"]);
    Route::post('{article}', [Articles::class, "commentPost"]);
});

Auth::routes(['register' => false]);

Auth::routes();
