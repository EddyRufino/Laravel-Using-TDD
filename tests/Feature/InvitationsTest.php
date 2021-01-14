<?php

namespace Tests\Feature;

use App\Http\Controllers\ProjectTaskController;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function non_owners_may_not_invite_users()
  {
    $this->actingAs(User::factory()->create())
      ->post(Project::factory()->create()->path() . '/invitations')
      ->assertStatus(403);
  }

  /** @test */
  public function a_project_owner_can_invite_a_user()
  { 
    $project = Project::factory()->create();

    $userToInvite = User::factory()->create();

    $this->actingAs($project->owner)
      ->post($project->path() . '/invitations', [
        'email' => $userToInvite->email
      ])
      ->assertRedirect($project->path());

    $this->assertTrue($project->members->contains($userToInvite));
  }

  /** @test */
  public function the_email_addres_must_be_associable_with_a_valid_birdbord_account()
  {
    $project = Project::factory()->create();

    $this->actingAs($project->owner)
      ->post($project->path() . '/invitations', [
        'email' => 'notauser@example.com'
      ])
      ->assertSessionHasErrors([
        'email' => 'The user you are inviting have a Birdboard account.'
      ]);
  }

  /** @test */
  public function invited_users_may_update_project_details()
  {
    $project = Project::factory()->create();

    $project->invite($newUser = User::factory()->create());

    $this->signIn($newUser);
    $this->post(action([ProjectTaskController::class, 'store'], $project), 
      $task = ['body' => 'Foo task']
    );

    $this->assertDatabaseHas('tasks', $task);
  }
}
