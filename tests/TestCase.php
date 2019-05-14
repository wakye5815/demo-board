<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker\Generator as Faker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var Faker
     */
    protected $faker = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = \Faker\Factory::create('ja_JP');
    }
}
