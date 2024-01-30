<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RefreshController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', [LoginController::class, "execute"]);
Route::post('refresh', [RefreshController::class, 'execute']);

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [LogoutController::class, 'execute']);

    Route::get('posts', [PostController::class, 'listPosts']);
    Route::get('categories', [CategoryController::class, 'listCategories']);

});
