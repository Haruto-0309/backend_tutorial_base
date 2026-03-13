<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Comment;
use App\Http\Resources\CommentResource;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    /**
     * コメント登録 (storeComment)
     * POST /articles/{article}/comments
     * 
     * @param StoreCommentRequest $request
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreCommentRequest $request, Article $article)
    {
        // FormRequestによるバリデーション済みデータを取得
        $validated = $request->validated();

        // DBに保存
        Comment::create([
            'article_id' => $article->id,
            'user_id'    => $validated['user_id'],
            'body'       => $validated['content'], // 入力名はcontent、DBはbody
        ]);

        return response()->json(['message' => '登録成功'], 200);
    }

    /**
     * コメント一覧 (indexComments)
     * GET /articles/{article}/comments
     * 
     * @param Article $article
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\JsonResponse
     */
    public function index(Article $article)
    {
        $comments = $article->comments;

        // Resourceを使って、設計書通りに変換して返す
        return CommentResource::collection($comments);
    }

    /**
     * 更新: PUT /articles/{article}/comments/{comment}
     * 
     * @param UpdateCommentRequest $request
     * @param Article $article
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCommentRequest $request, Article $article, Comment $comment)
    {
        $validated = $request->validated();

        // 更新
        $comment->update(['body' => $validated['content']]);

        return response()->json(['message' => '更新成功'], 200);
    }

    /**
     * 削除: DELETE /articles/{article}/comments/{comment}
     * 
     * @param Article $article
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Article $article, Comment $comment)
    {
        $comment->delete();

        return response()->json(['message' => '削除成功'], 200);
    }
}
