<?php

namespace Tests\Feature\Account;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\ResponseBuilders\SuccessResponseBuilder;
use App\User;
use App\Board;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var User
     */
    private $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class, 'testUser')->create();
    }

    /**
     * @test
     */
    public function 新規ボードを作成する()
    {
        $params = ['name' => 'test_board'];

        $expectedResponse = (new SuccessResponseBuilder())
            ->setContent(['all_board_list' => [[
                'name' => $params['name'],
                'owner_name' => $this->user->name
            ]]])
            ->toArray();

        $this->actingAs($this->user)
            ->postJson('/api/board/create', $params)
            ->assertStatus(200)
            ->assertJson($expectedResponse);

        $board = Board::first();
        $this->assertEquals($params['name'], $board->name);
        $this->assertEquals($this->user->id, $board->owner_user_id);
    }
}
