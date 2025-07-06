<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('comment', 'CommentCrudController');
    Route::crud('friendship', 'FriendshipCrudController');
    Route::crud('post', 'PostCrudController');
    Route::crud('fellower', 'FellowerCrudController');
    Route::crud('fellowing', 'FellowingCrudController');
    Route::get('user/{id}/change-status', [\App\Http\Controllers\Admin\UserCrudController::class, 'changeStatus']);
    Route::get('user/{id}/set-status/{status}', [\App\Http\Controllers\Admin\UserCrudController::class, 'setStatus']);
}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
