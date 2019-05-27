<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReplyComment extends Model
{
    protected $fillable = ['to_comment_id', 'from_comment_id'];
}
