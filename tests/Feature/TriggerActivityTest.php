<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function creating_a_project()
  {
    $project = Project::factory()->create();

    $this->assertCount(1, $project->activity);

    $this->assertEquals('created', $project->activity[0]->description);
  }

  /** @test */
  public function updating_a_project()
  {
    $project = Project::factory()->create();

    $project->update(['title' => 'changed']);

    $this->assertCount(2, $project->activity);

    $this->assertEquals('updated', $project->activity->last()->description);
  }

  /** @test */
  public function craeting_a_new_task()
  {
    $project = Project::factory()->create();

    $project->addTask('Some task');

    $this->assertCount(2, $project->activity);

    $this->assertEquals('created_task', $project->activity->last()->description);
  }

  /** @test */
  public function completing_a_task()
  {
    $project = Project::factory()->create();

    $task = Task::factory()->create(['project_id' => $project]);
    
    $this->signIn($project->owner)->patch($project->tasks[0]->path(), [
      'body' => 'foobar',
      'completed' => true
    ]);

    $this->assertCount(3, $project->activity);

    $this->assertEquals('completed_task', $project->activity->last()->description);
  }

  /** @test */
  public function incompleting_a_task()
  {
    $project = Project::factory()->create();

    $task = Task::factory()->create(['project_id' => $project]);
    
    $this->signIn($project->owner)->patch($project->tasks[0]->path(), [
      'body' => 'foobar',
      'completed' => true
    ]);

    $this->assertCount(3, $project->activity);

    $this->patch($project->tasks[0]->path(), [
      'body' => 'foobar',
      'completed' => false
    ]);

    $project->refresh();

    $this->assertCount(4, $project->activity);

    $this->assertEquals('incompleted_task', $project->activity->last()->description);
  }

  /** @test */
  public function deleting_a_task()
  {
    $this->signIn();

    $project = Project::factory()->create();

    $task = Task::factory()->create(['project_id' => $project]);

    $project->tasks[0]->delete();

    $this->assertCount(3, $project->activity);
  }
}
