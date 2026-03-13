<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    /**
     * ユーザー登録
     * 
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create($validated);

        return response()->json([
            'message' => 'ユーザー登録に成功しました',
            'user' => $user
        ], 201);
    }

    /**
     * ユーザー一覧取得
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(User::all());
    }
}