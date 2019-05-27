<?php

namespace Tests\Unit\Models\CommentCount;

use Tests\TestCaseRequireUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Board;
use App\Models\Comment;
use App\Models\User;
use App\Models\CommentCount;
use App\Models\ReplyComment;

class ReplyCountAvgInBoardTest extends TestCaseRequireUser
{
    use RefreshDatabase;

    /**
     * @var Board
     */
    private $board = null;

    /**
     * @var integer
     */
    private $commentCount = 0;

    /**
     * @var integer
     */
    private $replyCount = 0;

    public function setUp(): void
    {
        parent::setUp();
        $this->board = factory(Board::class)->create([
            'owner_user_id' => $this->user->id
        ]);

        $userList = factory(User::class, rand(5, 15))->create();
        $commentList = $userList->flatMap(function ($user, $i) {
            return factory(Comment::class, rand(5, 15))->create([
                'board_id' => $this->board->id,
                'owner_user_id' => $user->id
            ]);
        });

        $this->commentCount = $commentList->count();

        $userList->each(function ($user, $i) use ($commentList) {
            $otherUserCommentIdList = $commentList
                ->map(function ($comment, $i) {
                    return $comment->id;
                })
                ->filter(function ($commentId, $i) use ($user) {
                    return $commentId != $user->id;
                });

            $replyCount = rand(5, 15);
            collect(range(1, $replyCount))->each(function () use ($otherUserCommentIdList, $user) {
                    factory(ReplyComment::class)->create([
                        'to_comment_id' => $otherUserCommentIdList->random(),
                        'from_comment_id' => factory(Comment::class)->create([
                            'board_id' => $this->board->id,
                            'owner_user_id' => $user->id
                        ])
                    ]);
                });

            $this->replyCount += $replyCount;
            $this->commentCount += $replyCount;
        });
    }

    /**
     * @test
     */
    public function 掲示板内のコメント返信平均回数を取得する()
    {
        $avg = CommentCount::findReplyCountAvgInBoard($this->board->id);
        $expected = $this->replyCount / $this->commentCount;

        $this->assertEquals($avg, $expected);
    }
}
