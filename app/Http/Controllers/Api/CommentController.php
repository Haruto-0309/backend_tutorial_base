<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * コメント登録 (storeComment)
     * POST /articles/{article_id}/comments
     */
    public function store(Request $request, $article_id)
    {
        // 設計書の CommentInput (content必須) に基づくバリデーション
        $validated = $request->validate([
            'content' => 'required|string'
        ]);

        // 保存処理（今回は省略）

        return response()->json(['message' => '登録成功'], 200);
    }

    /**
     * コメント一覧 (indexComments)
     * GET /articles/{article_id}/comments
     */
    public function index($article_id)
    {
        $comments = [
            [
                'article_id' => (int)$article_id,
                'comment_id' => 5,
                'body' => 'この記事のリスク評価は非常に参考になります。',
                'created_at' => now()->toIso8601String(),
                'updated_at' => now()->toIso8601String(),
            ]
        ];

        return response()->json($comments, 200);
    }
}
