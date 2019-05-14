<?php

namespace Tests\Feature\Account;

use Tests\TestCaseRequireUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\ResponseBuilders\SuccessResponseBuilder;
use App\Board;
use App\Comment;

class TopTest extends TestCaseRequireUser
{
    use RefreshDatabase;

    /**
     * @var Board
     */
    private $board = null;

    private const COMMENT_COUNT = 30;

    /**
     * @var array
     */
    private $commmentList = [];

    public function setUp(): void
    {
        parent::setUp();
        $this->board = factory(Board::class)->create([
            'owner_user_id' => $this->user->id
        ]);
        $this->commmentList = factory(Comment::class, $this::COMMENT_COUNT)->create([
            'owner_user_id' => $this->user->id,
            'board_id' => $this->board->id
        ]);
    }

    /**
     * @test
     */
    public function 掲示板のTOP情報を取得する()
    {
        $params = ['board_id' => $this->board->id];

        $expectedResponse = (new SuccessResponseBuilder())
            ->setContent(['board' => [
                'name' => $this->board->name,
                'owner_name' => $this->user->name
            ]])
            ->toArray();

        $this->json('GET', '/api/board/top', $params)
            ->assertStatus(200)
            ->assertJson($expectedResponse)
            ->assertJsonCount($this::COMMENT_COUNT, 'content.comment_list');
    }
}
