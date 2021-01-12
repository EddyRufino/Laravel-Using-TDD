<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
	use WithFaker, RefreshDatabase;

  /** @test */
  public function it_has_a_path()
  {
    $project = Project::factory()->create();

    $this->assertEquals('/projects/' . $project->id, $project->path());
  }

  /** @test */
  public function it_belogns_to_an_owner()
  {
    $project = Project::factory()->create();

    $this->assertInstanceOf('App\Models\User', $project->owner);
  }

  /** @test */
  public function it_can_add_a_task()
  {
    $project = Project::factory()->create();

    $task = $project->addTask('new task');

    $this->assertCount(1, $project->tasks);

    $this->assertTrue($project->tasks->contains($task));
  }

  /** @test */
  public function it_can_invite_a_user()
  {
    $project = Project::factory()->create();

    $project->invite($user = User::factory()->create());

    $this->assertTrue($project->members->contains($user));
  }
}
