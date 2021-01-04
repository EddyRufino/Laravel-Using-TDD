<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Project;
use App\Models\User;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
  use WithFaker, RefreshDatabase;

  /** @test */
  public function guests_cannot_manage_projects()
  {
    // $this->withoutExceptionHandling();

    $project = Project::factory()->create();

    $this->get('/projects')->assertRedirect('login');
    $this->get('/projects/create')->assertRedirect('login');
    $this->get($project->path())->assertRedirect('login');
    $this->get($project->path().'/edit')->assertRedirect('login');
    $this->post('/projects', $project->toArray())->assertRedirect('login');
  }

  /** @test */
  public function a_user_can_create_project()
  {
    // $this->withoutExceptionHandling();

    $this->signIn();

    $this->get('/projects/create')->assertStatus(200);

    $data = [
      'title'       => $this->faker->sentence,
      'description' => $this->faker->sentence,
      'notes'       => 'General notes'
    ];

    $response = $this->post('/projects', $data);

    $project = Project::where($data)->first();

    $response->assertRedirect($project->path());

    $this->assertDatabaseHas('projects', $data);

    $this->get($project->path())
      ->assertSee($data['title'])
      ->assertSee($data['description'])
      ->assertSee($data['notes']);
  }

  /** @test */
  public function a_user_can_update_a_project()
  {
    $this->withoutExceptionHandling();

    $this->signIn();

    $project = Project::factory()->create(['owner_id' => auth()->id()]);

    $this->patch($project->path(), [
      'title' => 'changed',
      'description' => 'changed',
      'notes' => 'changed'
    ])->assertRedirect($project->path());

    $this->get($project->path() . '/edit')->assertOk();

    $this->assertDatabaseHas('projects', ['notes' => 'changed']);
  }

  /** @test */
  public function an_authenticated_user_cannot_view_the_projects_of_others()
  {
    // $this->withoutExceptionHandling();

    $this->signIn();

    $project = Project::factory()->create();

    $this->get($project->path())->assertStatus(403);
  }

  /** @test */
  public function an_authenticated_user_cannot_update_the_projects_of_others()
  {
    // $this->withoutExceptionHandling();

    $this->signIn();

    $project = Project::factory()->create();

    $this->patch($project->path(), [])->assertStatus(403);
  }

  /** @test */
  public function a_project_require_a_title()
  {
    $this->signIn();

    $data = Project::factory()->raw(['title' => '']);

    $this->post('/projects', $data)
        ->assertSessionHasErrors('title');
  }

  /** @test */
  public function a_project_require_a_description()
  {
    $this->signIn();

    $data = Project::factory()->raw(['description' => '']);
    
    $this->post('/projects', $data)
        ->assertSessionHasErrors('description');
  }

  /** @test */
  public function a_user_can_view_their_project()
  {
    $this->withoutExceptionHandling(); // Porque sino sale html

    $this->signIn();

    $project = Project::factory()->create(['owner_id' => auth()->id()]);
    
    $this->get($project->path())
      ->assertSee($project->title)
      ->assertSee($project->description);
  }

}
