<?php

namespace Tests\Feature\Comment;

use Tests\TestCaseRequireUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\ResponseBuilders\SuccessResponseBuilder;
use App\Board;
use App\Comment;

class FindTest extends TestCaseRequireUser
{
    use RefreshDatabase;

    /**
     * @var Board
     */
    private $board = null;

    /**
     * @var Comment
     */
    private $comment = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->board = factory(Board::class)->create([
            'owner_user_id' => $this->user->id
        ]);
        $this->comment = factory(Comment::class)->create([
            'owner_user_id' => $this->user->id,
            'board_id' => $this->board->id
        ]);
    }

    /**
     * @test
     */
    public function 一つの任意のコメントを取得する()
    {
        $params = ['comment_id' => $this->comment->id];

        $expectedResponse = (new SuccessResponseBuilder())
            ->setContent(['comment' => [
                'board_id' => $this->board->id,
                'content' => $this->comment->content,
                'owner_user' => $this->user->toArray(),
                'owner_user_id' => $this->user->id
            ]])
            ->toArray();

        $this->actingAs($this->user)
            ->json('GET', '/api/comment/find', $params)
            ->assertStatus(200)
            ->assertJsonCount(1, 'content')
            ->assertJson($expectedResponse);
    }
}
