<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GitHubController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('github')->group(function () {
    Route::get('/user/{username}', [GitHubController::class, 'getUser']);
    Route::get('/user/{username}/followings', [GitHubController::class, 'getFollowings']);
});
