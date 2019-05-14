<?php

namespace Tests\Feature\Board;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use App\User;
use App\Board;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    private const BOARD_COUNT = 10;

    /**
     * @var User
     */
    private $user = null;

    /**     
     * @var Collection
     */
    private $boardList = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class, 'testUser')->create();
        $this->boardList = collect(
            factory(Board::class, $this::BOARD_COUNT)->create([
                'owner_user_id' => $this->user->id
            ])
        );
    }

    /**
     * @test
     */
    public function 登録済みの全掲示板を取得する()
    {
        $response = $this->get('/api/board/all');
        $response->assertStatus(200)
            ->assertJsonCount($this::BOARD_COUNT, 'content.all_board_list');
    }
}
