<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Models\Comment;

class CommentCount
{
    public static function findUserCommentCountInBoard($boardId, $userId)
    {
        return Comment::where('board_id', $boardId)
            ->where('owner_user_id', $userId)
            ->count();
    }

    public static function findUserReplyCountInBoard($boardId, $userId)
    {
        return DB::table('comments')
            ->select('comments.*')
            ->join('reply_comments', 'reply_comments.to_comment_id', '=', 'comments.id')
            ->where('comments.board_id', $boardId)
            ->where('comments.owner_user_id', $userId)
            ->count();
    }

    public static function findUserReplyCountAvgInBoard($boardId, $userId)
    {
        $sub = DB::table('comments')
            ->select(DB::raw('count(*) as count'))
            ->join('reply_comments', 'reply_comments.to_comment_id', '=', 'comments.id')
            ->where('comments.board_id', $boardId)
            ->where('comments.owner_user_id', $userId)
            ->groupBy('comments.id');

        return DB::table(DB::raw("({$sub->toSql()}) as sub"))
            ->mergeBindings($sub)
            ->avg('sub.count');
    }

    public static function findUserCommentCountAvgInBoard($id)
    {
        $sub = DB::table('comments')
            ->select(DB::raw('count(*) as count'))
            ->where('board_id', '=', $id)
            ->groupBy('owner_user_id');

        return DB::table(DB::raw("({$sub->toSql()}) as sub"))
            ->mergeBindings($sub)
            ->avg('sub.count');
    }

    public static function findReplyCountAvgInBoard($id)
    {
         $replyCount = DB::table('comments')
            ->join('reply_comments', 'reply_comments.to_comment_id', '=', 'comments.id')
            ->where('comments.board_id', '=', $id)
            ->count();
        
        $commentCount = Comment::where('board_id', '=', $id)->count();

        return $replyCount / $commentCount;
    }
}