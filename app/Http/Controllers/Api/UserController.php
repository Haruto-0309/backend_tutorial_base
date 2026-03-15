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

        $emailVerification = \App\Models\EmailVerification::where('email', $validated['email'])
            ->where('token', $validated['token'])
            ->first();

        if (!$emailVerification || $emailVerification->expires_at->isPast()) {
            return response()->json([
                'message' => '無効な認証コード、または有効期限が切れています。',
            ], 422);
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
        ]);

        $emailVerification->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'ユーザー登録に成功しました',
            'user' => $user,
            'access_token' => $token
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