<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    //  保存を許可するカラムの指定
    protected $fillable = [
        "username",
        "body",
        "article_id"
        ];
}
