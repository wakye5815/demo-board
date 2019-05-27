<?php

namespace Tests\Unit\Models\CommentCount;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Board;
use App\Models\Comment;
use App\Models\User;
use App\Models\CommentCount;
use Tests\TestCaseRequireUser;

use Illuminate\Support\Facades\DB;

class UserCommentCountAvgInBoardTest extends TestCaseRequireUser
{
    use RefreshDatabase;

    /**
     * @var Board
     */
    private $board = null;

    /**
     * @var array
     */
    private $userCommentCountList;

    public function setUp(): void
    {
        parent::setUp();
        $this->board = factory(Board::class)->create([
            'owner_user_id' => $this->user->id
        ]);
        $this->userCount = rand(1, 10);
        factory(User::class, $this->userCount)
            ->create()
            ->each(function ($user, $i) {
                $commentCount = rand(1, 10);
                factory(Comment::class, $commentCount)->create([
                    'board_id' => $this->board->id,
                    'owner_user_id' => $user->id
                ]);
                $this->userCommentCountList[] = $commentCount;
            });
    }

    /**
     * @test
     */
    public function 掲示板内ユーザーのコメント平均回数を取得する()
    {
        $avg = CommentCount::findUserCommentCountAvgInBoard(
            $this->board->id
        );

        $expected = array_sum($this->userCommentCountList) / count($this->userCommentCountList);
        $this->assertEquals($avg, $expected);
    }
}
