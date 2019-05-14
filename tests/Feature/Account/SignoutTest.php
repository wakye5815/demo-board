<?php

namespace Tests\Feature\Account;

use Tests\TestCaseRequireUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\ResponseBuilders\SuccessResponseBuilder;

class SignoutTest extends TestCaseRequireUser
{
    use RefreshDatabase;

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
