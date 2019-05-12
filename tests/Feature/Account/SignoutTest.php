<?php

namespace Tests\Feature\Account;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Http\ResponseBuilders\SuccessResponseBuilder;

class SignoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var App\User
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
    public function サインアウトする()
    {
        $this->actingAs($this->user)
            ->get('/api/account/signout')
            ->assertStatus(200)
            ->assertJson((new SuccessResponseBuilder())->toArray());

        $this->assertGuest();
    }
}
