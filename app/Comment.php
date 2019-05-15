<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    protected $fillable = ['board_id', 'owner_user_id', 'content'];

    private static $usersJoinColumns = [
        'comments.id as comment_id',
        'comments.content',
        'comments.board_id',
        'users.id as owner_id',
        'users.name as owner_name',
        'comments.created_at',
        'comments.updated_at'
    ];

    public static function findListByBoardId($id)
    {
        return DB::table('comments')
            ->select(Comment::$usersJoinColumns)
            ->join('users', 'comments.owner_user_id', '=', 'users.id')
            ->where('comments.board_id', $id)
            ->get();
    }

    public static function findOneById($id)
    {
        return DB::table('comments')
            ->select(Comment::$usersJoinColumns)
            ->join('users', 'comments.owner_user_id', '=', 'users.id')
            ->where('comments.id', $id)
            ->first();
    }
}
