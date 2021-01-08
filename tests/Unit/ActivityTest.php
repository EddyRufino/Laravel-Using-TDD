<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Project;
use App\Models\User;
use Tests\TestCase;

class ActivityTest extends TestCase
{
	use WithFaker, RefreshDatabase;

	/** @test */
	public function it_has_a_user()
	{
		$this->signIn();
		
		$project = Project::factory()->create();

		$this->assertInstanceOf(User::class, $project->activity->first()->user);
	}
}
