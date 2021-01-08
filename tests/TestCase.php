<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
    	return $this->actingAs($user ?: User::factory()->create()); // Sin Setup

      // $user = $user ?: User::factory()->count(1)->create();

      // $this->actingAs($user);

      // return $user;
    }
}
