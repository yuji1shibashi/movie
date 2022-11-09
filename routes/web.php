<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RankingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * ログイン
 */
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');
/**
 * ユーザー新規作成
 */
Route::get('/register', [RegisteredUserController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->middleware('guest');

/**
 * ログイン必須
 */
Route::middleware('auth')->group(function() {
    /**
     * ホーム
     */
    Route::get('/', [MovieController::class, 'index']);

    /**
     * ユーザー
     */
    Route::prefix('user')->group(function () {
        Route::get('list', [UserController::class, 'index']);
        Route::post('create', [UserController::class, 'create']);
        Route::post('update/{userId}', [UserController::class, 'update']);
        Route::post('delete/{userId}', [UserController::class, 'delete']);
    });

    /**
     * 映画
     */
    Route::prefix('movie')->group(function () {
        Route::get('list', [MovieController::class, 'index']);
        Route::post('create', [MovieController::class, 'create']);
        Route::post('update/{movieId}', [MovieController::class, 'update']);
        Route::post('delete/{movieId}', [MovieController::class, 'delete']);
        Route::post('vote', [MovieController::class, 'vote']);
    });

    /**
     * ランキング
     */
    Route::prefix('ranking')->group(function () {
        Route::get('/', [RankingController::class, 'index']);
    });

    /**
     * ログアウト
     */
    Route::any('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
