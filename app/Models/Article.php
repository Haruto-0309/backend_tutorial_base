<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //  保存を許可するカラムの指定
    protected $fillable = [
        "title",
        "body"
        ];
}
