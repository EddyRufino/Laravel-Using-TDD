<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Facades\Tests\Setup\ProjectFactory;
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

	/** @test */
  function a_user_has_accessible_projects()
  {
    $john = $this->signIn();

    ProjectFactory::ownedBy($john)->create();

    $this->assertCount(1, $john->accessibleProjects());

    $sally = User::factory()->create();
    $nick = User::factory()->create();

    $project = tap(ProjectFactory::ownedBy($sally)->create())->invite($nick);

    $this->assertCount(1, $john->accessibleProjects());

    $project->invite($john);

    $this->assertCount(2, $john->accessibleProjects());
  }
}
