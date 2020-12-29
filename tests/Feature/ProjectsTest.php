<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Project;
use App\Models\User;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
  use WithFaker, RefreshDatabase;

  /** @test */
  public function only_authenticated_users_can_create_projects()
  {
    // $this->withoutExceptionHandling();

    $data = Project::factory()->raw();
    
    $this->post('/projects', $data)->assertRedirect('login');
  }


  /** @test */
  public function a_user_can_create_project()
  {
    // $this->withoutExceptionHandling();
    $this->actingAs(User::factory()->create());

    $data = [
      'title'         => $this->faker->sentence,
      'description'   => $this->faker->paragraph,
    ];

    $this->post('/projects', $data)->assertRedirect('/projects');

    $this->assertDatabaseHas('projects', $data);

    $this->get('/projects')->assertSee($data['title']);
  }

  /** @test */
  public function a_project_require_a_title()
  {
    $this->actingAs(User::factory()->create());

    $data = Project::factory()->raw(['title' => '']);

    $this->post('/projects', $data)
        ->assertSessionHasErrors('title');
  }

  /** @test */
  public function a_project_require_a_description()
  {
    $this->actingAs(User::factory()->create());

    $data = Project::factory()->raw(['description' => '']);
    
    $this->post('/projects', $data)
        ->assertSessionHasErrors('description');
  }

  /** @test */
  public function a_user_can_view_a_project()
  {
    $this->withoutExceptionHandling(); // Porque sino sale html

    $project = Project::factory()->create();

    $this->get($project->path())
      ->assertSee($project->title)
      ->assertSee($project->description);
  }

}
