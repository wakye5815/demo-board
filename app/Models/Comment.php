<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserBadge;

class Comment extends Model
{
    use SoftDeletes;

    protected $appends = ['is_reply', 'to_comment', 'is_deleted'];

    protected $fillable = ['board_id', 'owner_user_id', 'content', 'to_comment_id'];

    protected $dates = ['deleted_at'];

    // コメント投稿者が掲示板内称号を持っていない場合付与する
    protected static function boot(){
        parent::boot();
        static::created(function($comment){
            if (User::hasBadgeInBoard($comment->owner_user_id, $comment->board_id)){
                return;
            }

            UserBadge::create([
                'user_id' => $comment->owner_user_id,
                'board_id' => $comment->board_id
            ]);
        });
    }

    public function owner_user()
    {
        return $this->belongsTo('App\Models\User', 'owner_user_id');
    }

    public function to_comment_list()
    {
        return $this->belongsToMany(
            'App\Models\Comment',
            'reply_comments',
            'from_comment_id',
            'to_comment_id'
        )
            ->withTrashed();
    }

    public function fromComment()
    {
        return $this->hasMany('App\Models\Comment', 'to_comment_id', 'id');
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
        return Comment::with([
            'owner_user.badge_list' => function ($query) use ($id) {
                return $query->wherePivot('board_id', '=', $id);
            },
            'to_comment_list.owner_user.badge_list' => function ($query) use ($id) {
                return $query->wherePivot('board_id', '=', $id);
            }
        ])
            ->withTrashed()
            ->where('board_id', $id)
            ->get();
    }

    public static function findOneById($id)
    {
        return Comment::with([
            'owner_user.badge_list' => function ($query) use ($id) {
                return $query->wherePivot('board_id', '=', $id);
            },
            'to_comment_list.owner_user.badge_list' => function ($query) use ($id) {
                return $query->wherePivot('board_id', '=', $id);
            }
        ])
            ->find($id);
    }
}
