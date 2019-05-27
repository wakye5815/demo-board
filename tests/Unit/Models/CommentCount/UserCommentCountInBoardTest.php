<?php

namespace Tests\Unit\Models\CommentCount;

use Tests\TestCaseRequireUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Board;
use App\Models\Comment;
use App\Models\User;
use App\Models\CommentCount;

class UserCommentCountInBoardTest extends TestCaseRequireUser
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

    public function setUp(): void
    {
        parent::setUp();
        $this->board = factory(Board::class)->create([
            'owner_user_id' => $this->user->id
        ]);
        factory(User::class, 5)
            ->create()
            ->each(function ($user, $i) {
                factory(Comment::class, rand(5, 15))->create([
                    'board_id' => $this->board->id,
                    'owner_user_id' => $user->id
                ]);
            });

        $this->commentCount = rand(5, 15);
        factory(Comment::class, $this->commentCount)->create([
            'board_id' => $this->board->id,
            'owner_user_id' => $this->user->id
        ]);
    }

    /**
     * @test
     */
    public function 掲示板内指定ユーザーのコメント回数を取得する()
    {
        $commentCount = CommentCount::findUserCommentCountInBoard(
            $this->board->id,
            $this->user->id
        );

        $this->assertEquals($this->commentCount, $commentCount);
    }
}
