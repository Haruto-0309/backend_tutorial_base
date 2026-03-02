<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //  保存を許可するカラムの指定
    protected $fillable = [
        "username",
        "body",
        "article?id"
        ];
}
