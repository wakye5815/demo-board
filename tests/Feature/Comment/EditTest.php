<?php

namespace Tests\Feature\Comment;

use Tests\TestCaseRequireUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\ResponseBuilders\SuccessResponseBuilder;
use App\Board;
use App\Comment;

class EditTest extends TestCaseRequireUser
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
    public function コメントを編集する()
    {
        $params = [
            'comment_id' => $this->comment->id,
            'new_content' => $this->faker->text
        ];

        $this->actingAs($this->user)
            ->patchJson('/api/comment/edit', $params)
            ->assertStatus(200)
            ->assertJson((new SuccessResponseBuilder())->toArray());

        $comment = Comment::first();
        $this->assertEquals($comment->board_id, $this->board->id);
        $this->assertEquals($comment->owner_user_id, $this->user->id);
        $this->assertEquals($comment->content, $params['new_content']);
    }
}
