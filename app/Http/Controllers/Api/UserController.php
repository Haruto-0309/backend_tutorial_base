<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = User::create($validated);

        return response()->json([
            'message' => 'ユーザー登録に成功しました',
            'user' => $user
        ], 201);
    }

    public function index()
    {
        return response()->json(User::all());
    }
}