<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  use HasFactory;

  protected $guarded = [];

  protected $casts = [
    'completed' => 'boolean'
  ];

  protected $touches = ['project']; // Actualizo una tarea this ayuda a ordenarla

  public function complete()
  {
    $this->update(['completed' => true]);
    
    $this->recordActivity('completed_task');
  }

  public function incomplete()
  {
    $this->update(['completed' => false]);

    $this->recordActivity('incompleted_task');
  }

  public function project()
  {
  	return $this->belongsTo(Project::class);
  }

  public function path()
  {
  	return "/projects/{$this->project->id}/tasks/{$this->id}";
  }

  public function recordActivity($description)
  {
    $this->activity()->create([
      'project_id' => $this->project_id,
      'description' => $description
    ]);
  }

  public function activity()
  {
    return $this->morphMany(Activity::class, 'subject')->latest();
  }
}
