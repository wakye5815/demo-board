<?php

namespace Tests;
use App\Models\User;

abstract class TestCaseRequireUser extends TestCase
{
    use CreatesApplication;

    /**
     * @var User
     */
    protected $user = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class, 'testUser')->create();
    }
}
