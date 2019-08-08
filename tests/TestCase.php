<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Sign in using default user
     */
    protected function signIn()
    {
        $this->actingAs(factory('App\User')->create());
    }
}
