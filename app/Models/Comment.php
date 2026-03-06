<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    //  保存を許可するカラムの指定
    protected $fillable = [
        "user_id",
        "body",
        "article_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
