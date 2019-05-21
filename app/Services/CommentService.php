<?php

namespace App\Services;

use App\Comment;
use App\ReplyComment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Model;

class CommentService
{
    /**
     * Undocumented function
     *
     * @param [type] $boardId
     * @param [type] $ownerUserId
     * @param [type] $content
     * @return void
     */
    public function create($boardId, $ownerUserId, $content)
    {
        return Comment::create([
            'board_id' => $boardId,
            'owner_user_id' => $ownerUserId,
            'content' => $content
        ]);
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     * @throws ModelNotFoundException
     */
    public function delete($id)
    {
        $comment = Comment::with('to_comment_list')->findOrFail($id);
        if ($comment->is_reply) $comment->to_comment_list()->detach();
        $comment->delete();
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return void
     * @throws ModelNotFoundException
     */
    public function update($id, $newContent)
    {
        Comment::findOrFail($id)->update(['content' => $newContent]);
    }

    /**
     * Undocumented function
     *
     * @param [type] $id
     * @return Model
     * @throws ModelNotFoundException
     */
    public function findOneById($id)
    {
        $result = Comment::findOneById($id);
        if (is_null($result)) throw new ModelNotFoundException();
        return $result;
    }

    /**
     * Undocumented function
     *
     * @param [type] $toCommentId
     * @param [type] $fromOwnerUserId
     * @param [type] $content
     * @return void
     */
    public function createReply($toCommentId, $fromOwnerUserId, $content)
    {
        $toComment = Comment::findOneById($toCommentId);
        if (is_null($toComment)) throw new ModelNotFoundException();

        $fromComment = Comment::create([
            'board_id' => $toComment->board_id,
            'owner_user_id' => $fromOwnerUserId,
            'content' => $content
        ]);

        ReplyComment::create([
            'to_comment_id' => $toComment->id,
            'from_comment_id' => $fromComment->id,
        ]);
    }

    public function findListByBoardId($boardId)
    {
        return Comment::findListByBoardId($boardId);
    }
}
