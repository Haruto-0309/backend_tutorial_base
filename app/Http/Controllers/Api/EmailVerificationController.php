<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmailVerificationRequest;
use App\Models\EmailVerification;
use App\Mail\EmailVerificationToken;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class EmailVerificationController extends Controller
{
    /**
     * 仮登録（トークン生成とメール送信）
     * 
     * @param StoreEmailVerificationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreEmailVerificationRequest $request)
    {
        $validated = $request->validated();
        $email = $validated['email'];

        // 6桁のランダムな数字のトークンを生成
        $token = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // 既存の仮登録があれば更新、なければ新規作成
        EmailVerification::updateOrCreate(
            ['email' => $email],
            [
                'token' => $token,
                'expires_at' => Carbon::now()->addHours(1),
            ]
        );

        // トークンを記載したメールを送信
        Mail::to($email)->send(new EmailVerificationToken($token));

        return response()->json([
            'message' => '認証コードをメールで送信しました',
        ], 200);
    }
}
