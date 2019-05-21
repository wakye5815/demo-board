<?php

namespace Tests\Feature\Comment;

use Tests\TestCaseRequireUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\ResponseBuilders\SuccessResponseBuilder;
use App\Board;
use App\Comment;

class CreateTest extends TestCaseRequireUser
{
    use RefreshDatabase;

    /**
     * @var Board
     */
    private $board = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->board = factory(Board::class)->create([
            'owner_user_id' => $this->user->id
        ]);
    }

    /**
     * @test
     */
    public function コメントを作成する()
    {
        $params = [
            'board_id' => $this->board->id,
            'content' => $this->faker->text
        ];

            $this->actingAs($this->user)
            ->postJson('/api/comment/create', $params)
            ->assertStatus(200)
            ->assertJson((new SuccessResponseBuilder())->toArray());

        $comment = Comment::first();
        $this->assertEquals($comment->board_id, $this->board->id);
        $this->assertEquals($comment->owner_user_id, $this->user->id);
        $this->assertEquals($comment->content, $params['content']);
    }
}
