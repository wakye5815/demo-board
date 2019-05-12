<?php

namespace Tests\Feature\Account;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Http\ResponseBuilders\SuccessResponseBuilder;

class SigninTest extends TestCase
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
    public function サインイン後ユーザー情報を返却する()
    {
        $params = [
            'signin_email' => env('TEST_USER_EMAIL'),
            'password' => env('TEST_USER_PASSWORD')
        ];

        $expectedResponse = (new SuccessResponseBuilder())
            ->setContent(['user' => [
                'name' => env('TEST_USER_NAME'),
                'email' => env('TEST_USER_EMAIL')
            ]])
            ->toArray();

        $this->postJson('/api/account/signin', $params)
            ->assertStatus(200)
            ->assertJson($expectedResponse);

        $this->assertAuthenticatedAs($this->user);
    }
}
