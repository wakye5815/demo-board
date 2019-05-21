<?php

namespace Tests\Feature\Comment;

use Tests\TestCaseRequireUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\ResponseBuilders\SuccessResponseBuilder;
use App\User;
use App\Board;
use App\Comment;
use App\ReplyComment;

class ReplyTest extends TestCaseRequireUser
{
    use RefreshDatabase;

    /**
     * @var User
     */
    protected $replyUser = null;

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
        $this->replyUser = factory(User::class)->create();
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
    public function コメントに返信する()
    {
        $params = [
            'to_comment_id' => $this->comment->id,
            'content' => $this->faker->text
        ];

        $res = $this->actingAs($this->replyUser)
            ->postJson('/api/comment/reply', $params);

        echo($res->baseResponse->__toString());

        $res->assertStatus(200)
            ->assertJson((new SuccessResponseBuilder())->toArray());

        $fromComment = Comment::where('owner_user_id', $this->replyUser->id)->first();
        $this->assertEquals($fromComment->board_id, $this->board->id);
        $this->assertEquals($fromComment->owner_user_id, $this->replyUser->id);
        $this->assertEquals($fromComment->content, $params['content']);

        $replyComment = ReplyComment::first();
        $this->assertEquals($replyComment->to_comment_id, $this->comment->id);
        $this->assertEquals($replyComment->from_comment_id, $fromComment->id);
    }
}
