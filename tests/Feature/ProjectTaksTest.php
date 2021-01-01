<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Project;
use App\Models\Task;
use Tests\TestCase;

class ProjectTaksTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function a_project_can_have_tasks()
  {
    $this->signIn();

    $project = auth()->user()->projects()->create(
      Project::factory()->raw()
    );

    $this->post($project->path() . '/tasks', ['body' => 'new task']);

    $this->get($project->path())->assertSee('new task');
  }

  /** @test */
  public function a_task_require_a_body()
  {
    $this->signIn();

    $project = auth()->user()->projects()->create(
      Project::factory()->raw()
    );

    $data = Task::factory()->raw(['body' => '']);

    $this->post($project->path() . '/tasks', $data)
      ->assertSessionHasErrors('body');
  }
}
