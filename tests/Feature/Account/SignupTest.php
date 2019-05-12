<?php

namespace Tests\Feature\Account;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Http\ResponseBuilders\SuccessResponseBuilder;

class SignupTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function サインアップする()
    {
        $params = [
            'name' => env('TEST_USER_NAME'),
            'signup_email' => env('TEST_USER_EMAIL'),
            'password' => env('TEST_USER_PASSWORD')
        ];

        $expectedResponse = (new SuccessResponseBuilder())
            ->setContent(['user' => [
                'name' => env('TEST_USER_NAME'),
                'email' => env('TEST_USER_EMAIL')
            ]])
            ->toArray();

        $this->postJson('/api/account/signup', $params)
            ->assertStatus(200)
            ->assertJson($expectedResponse);

        $user = User::first();
        $this->assertEquals($params['name'], $user->name);
        $this->assertEquals($params['signup_email'], $user->email);
    }
}
