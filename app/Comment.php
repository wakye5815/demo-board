<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $appends = ['is_reply', 'to_comment', 'is_deleted'];

    protected $fillable = ['board_id', 'owner_user_id', 'content', 'to_comment_id'];

    protected $dates = ['deleted_at'];

    public function owner_user()
    {
        return $this->belongsTo('App\User', 'owner_user_id');
    }

    public function to_comment_list()
    {
        return $this->belongsToMany(
            'App\Comment',
            'reply_comments',
            'from_comment_id',
            'to_comment_id'
        )
            ->withTrashed();
    }

    public function fromComment()
    {
        return $this->hasMany('App\Comment', 'to_comment_id', 'id');
    }

    public function getIsReplyAttribute()
    {
        return !$this->to_comment_list->isEmpty();
    }

    public function getToCommentAttribute()
    {
        return $this->to_comment_list->first();
    }

    public function getIsDeletedAttribute()
    {
        return !is_null($this->deleted_at);
    }

    public function getContentAttribute($value)
    {
        return $this->is_deleted ? '削除されたコメントです' : $value;
    }

    public static function findListByBoardId($id)
    {
        return Comment::with(['owner_user', 'to_comment_list.owner_user'])
            ->withTrashed()
            ->where('board_id', $id)
            ->get();
    }

    public static function findOneById($id)
    {
        return Comment::with(['owner_user', 'to_comment_list.owner_user'])
            ->find($id);
    }
}
