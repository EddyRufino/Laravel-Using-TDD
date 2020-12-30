<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Project;
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
}
