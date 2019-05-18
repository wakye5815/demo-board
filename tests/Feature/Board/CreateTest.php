<?php

namespace Tests\Feature\Account;

use Tests\TestCaseRequireUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\ResponseBuilders\SuccessResponseBuilder;
use App\Board;

class CreateTest extends TestCaseRequireUser
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function 新規ボードを作成する()
    {
        $params = ['name' => 'test_board'];

        $expectedResponse = (new SuccessResponseBuilder())
            ->setContent(['all_board_list' => [[
                'name' => $params['name'],
                'owner_user' => $this->user->toArray(),
                'owner_user_id' => $this->user->id
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
