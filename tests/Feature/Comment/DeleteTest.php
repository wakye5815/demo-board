<?php

namespace Tests\Feature\Comment;

use Tests\TestCaseRequireUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\ResponseBuilders\SuccessResponseBuilder;
use App\Board;
use App\Comment;

class DeleteTest extends TestCaseRequireUser
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
    public function コメントを削除する()
    {
        $params = ['comment_id' => $this->comment->id];

        $expectedResponse = (new SuccessResponseBuilder())
            ->setContent(['comment_list' => []])
            ->toArray();

        $this->actingAs($this->user)
            ->deleteJson('/api/comment/delete', $params)
            ->assertStatus(200)
            ->assertJson($expectedResponse);

        $this->assertTrue(Comment::all()->isEmpty());
    }
}
