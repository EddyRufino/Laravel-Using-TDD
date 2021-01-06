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
  public function a_task_can_be_update()
  {
    $this->withoutExceptionHandling();

    // $project = app(ProjectFactory::class)
    //   ->ownedBy($this->signIn())
    //   ->withTasks(1)
    //   ->create();

    $this->signIn();

    $project = auth()->user()->projects()->create(
      Project::factory()->raw()
    );

    $task = $project->addTask('Test task');

    $this->patch($task->path(), [
      'body'      => 'changed'
    ]);

    $this->assertDatabaseHas('tasks', [
      'body'      => 'changed'
    ]);
  }

  /** @test */
  public function a_task_can_be_completed()
  {
    $this->withoutExceptionHandling();

    $this->signIn();

    $project = auth()->user()->projects()->create(
      Project::factory()->raw()
    );

    $task = $project->addTask('Test task');

    $this->patch($task->path(), [
      'body'      => 'changed',
      'completed' => true
    ]);

    $this->assertDatabaseHas('tasks', [
      'body'      => 'changed',
      'completed' => true
    ]);
  }

  /** @test */
  public function a_task_can_be_marked_as_incomplete()
  {
    $this->withoutExceptionHandling();

    $this->signIn();

    $project = auth()->user()->projects()->create(
      Project::factory()->raw()
    );

    $task = $project->addTask('Test task');

    $this->patch($task->path(), [
      'body'      => 'changed',
      'completed' => true
    ]);

    $this->patch($task->path(), [
      'body'      => 'changed',
      'completed' => false
    ]);

    $this->assertDatabaseHas('tasks', [
      'body'      => 'changed',
      'completed' => false
    ]);
  }

  /** @test */
  public function only_the_owner_of_a_project_can_add_tasks()
  {
    $this->signIn();

    $project = Project::factory()->create();

    $this->post($project->path() . '/tasks', ['body' => 'Test task'])
      ->assertStatus(403);

    $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
  }

  /** @test */
  public function only_the_owner_of_a_project_can_update_a_task()
  {
    $this->signIn();

    $project = Project::factory()->create();
    $task = $project->addTask('Test task');

    $this->patch($task->path(), ['body' => 'changed'])->assertStatus(403);

    $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
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
