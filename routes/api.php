<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CommentController;

// ユーザー登録
Route::post('/users', [UserController::class, 'store']);

// ユーザー一覧取得
Route::get('/users', [UserController::class, 'index']);

// コメント登録
Route::post('/articles/{article_id}/comments', [CommentController::class, 'store']);

// コメント一覧取得
Route::get('/articles/{article_id}/comments', [CommentController::class, 'index']);

// コメント削除
Route::delete('/articles/{article_id}/comments/{comment_id}', [CommentController::class, 'destroy']);

// コメント更新
Route::put('/articles/{article_id}/comments/{comment_id}', [CommentController::class, 'update']);