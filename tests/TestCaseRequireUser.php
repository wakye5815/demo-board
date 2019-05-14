<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\User;

abstract class TestCaseRequireUser extends BaseTestCase
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
