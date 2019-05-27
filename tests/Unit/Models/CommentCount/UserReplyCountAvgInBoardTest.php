<?php

namespace Tests\Unit\Models\CommentCount;

use Tests\TestCaseRequireUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Board;
use App\Models\Comment;
use App\Models\User;
use App\Models\CommentCount;
use App\Models\ReplyComment;

class UserReplyCountAvgInBoardTest extends TestCaseRequireUser
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

        $this->commentCount = rand(5, 15);
        $testUserCommentIdList = factory(Comment::class, $this->commentCount)
            ->create([
                'board_id' => $this->board->id,
                'owner_user_id' => $this->user->id
            ])
            ->map(function ($comment, $i) {
                return $comment->id;
            });

        $otherUserCommentList = factory(User::class, rand(5, 15))
            ->create()
            ->flatMap(function ($user, $i) {
                return factory(Comment::class, rand(5, 15))->create([
                    'board_id' => $this->board->id,
                    'owner_user_id' => $user->id
                ]);
            });

        $otherUserCommentList->each(function ($comment, $i) use ($testUserCommentIdList) {
            factory(ReplyComment::class)->create([
                'to_comment_id' => $testUserCommentIdList->random(),
                'from_comment_id' => $comment->id
            ]);
        });

        $this->replyCount = $otherUserCommentList->count();
    }

    /**
     * @test
     */
    public function 掲示板内の指定ユーザーコメントの返信平均回数を取得する()
    {
        $avg = CommentCount::findUserReplyCountAvgInBoard(
            $this->board->id,
            $this->user->id
        );

        $expected = $this->replyCount / $this->commentCount;

        $this->assertEquals($avg, $expected);
    }
}
