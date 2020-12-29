<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Project;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_can_create_project()
    {
        $this->withoutExceptionHandling();
        // $this->withExceptionHandling();

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
        $data = Project::factory()->raw(['title' => '']);

        $this->post('/projects', $data)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_require_a_description()
    {
        $data = Project::factory()->raw(['description' => '']);
        
        $this->post('/projects', $data)
            ->assertSessionHasErrors('description');
    }
}
