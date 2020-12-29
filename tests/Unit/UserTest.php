<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Project;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	public function a_user_has_projects()
	{
		$user = User::factory()->create();

		$this->assertInstanceOf(Collection::class, $user->projects);
	}
}
