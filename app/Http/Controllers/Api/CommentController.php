<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment; // 追加：モデルを使う
use App\Http\Resources\CommentResource; // 追加：変換器を使う

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
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string|min:10|max:100'
        ]);

        // DBに保存
        Comment::create([
            'article_id' => $article_id,
            'user_id'    => $validated['user_id'],
            'body'       => $validated['content'], // 入力名はcontent、DBはbody
        ]);

        return response()->json(['message' => '登録成功'], 200);
    }

    /**
     * コメント一覧 (indexComments)
     * GET /articles/{article_id}/comments
     */
    public function index($article_id)
    {
        $comments = Comment::where('article_id', $article_id)->get();

        // Resourceを使って、設計書通りに変換して返す
        return CommentResource::collection($comments);
    }

    /**
     * 更新: PUT /articles/{article_id}/comments/{comment_id}
     */
    public function update(Request $request, $article_id, $comment_id)
    {
        // 該当するコメントを検索（なければ404エラーを自動で出す）
        $comment = Comment::findOrFail($comment_id);

        $validated = $request->validate([
            'content' => 'required|string|min:10|max:100',
        ]);

        // 更新
        $comment->update(['body' => $validated['content']]);

        return response()->json(['message' => '更新成功'], 200);
    }

    /**
     * 削除: DELETE /articles/{article_id}/comments/{comment_id}
     */
    public function destroy($article_id, $comment_id)
    {
        $comment = Comment::findOrFail($comment_id);
        $comment->delete();

        return response()->json(['message' => '削除成功'], 200);
    }
}
