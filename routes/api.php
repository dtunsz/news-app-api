<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsapiArticleController;
use App\Http\Controllers\GuardianArticleController;
use App\Http\Controllers\NytArticleController;
use App\Http\Controllers\AuthController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return ["user" => $request->user(), "profile" => $request->user()->profile];
})->middleware('auth:sanctum');


Route::apiResource('profiles', ProfileController::class);

Route::get('/news_api/articles', [NewsapiArticleController::class, 'index'])->name('newsapi.articles');
Route::get('/guardian/articles', [GuardianArticleController::class, 'index'])->name('guardian.articles');
Route::get('/nyt/articles', [NytArticleController::class, 'index'])->name('nyt.articles');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/getlatest', [AuthController::class, 'get_latest']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');