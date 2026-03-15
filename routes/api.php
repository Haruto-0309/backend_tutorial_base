<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\AuthController;

// ユーザー仮登録
Route::post('/register/pre', [EmailVerificationController::class, 'store']);

// ユーザー登録
Route::post('/users', [UserController::class, 'store']);

// ログイン
Route::post('/login', [AuthController::class, 'login']);

// ユーザー一覧取得
Route::get('/users', [UserController::class, 'index']);

// コメント一覧取得 (誰でも閲覧可能)
Route::get('/articles/{article}/comments', [CommentController::class, 'index']);

// === 認証必須のAPI ===
Route::middleware('auth:sanctum')->group(function () {
    // ログアウト
    Route::post('/logout', [AuthController::class, 'logout']);

    // コメント登録
    Route::post('/articles/{article}/comments', [CommentController::class, 'store']);

    // コメント更新
    Route::put('/articles/{article}/comments/{comment}', [CommentController::class, 'update'])->scopeBindings();

    // コメント削除
    Route::delete('/articles/{article}/comments/{comment}', [CommentController::class, 'destroy'])->scopeBindings();
});