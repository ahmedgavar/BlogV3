<?php

use App\Http\Controllers\Api\User\UserAuthController;
use App\Http\Controllers\Api\User\UserPostController;
use Illuminate\Support\Facades\Route;

Route::namespace ('Api/User')->group(function () {
// authentication
    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('login', [UserAuthController::class, 'loginUser']);
    Route::post('logout', [UserAuthController::class, 'logoutUser'])->middleware(['auth:sanctum']);

// end authentication

});
Route::get('posts/search/{title}', [UserPostController::class, 'search']);

Route::apiResource('posts', UserPostController::class);
