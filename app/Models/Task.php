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

  protected static function boot()
  {
    parent::boot();

    static::created(function ($task) {
      $task->project->recordActivity('created_task');
    });

    // static::updated(function ($task) {

    //   if (! $task->completed) return;

    //   $task->project->recordActivity('completed_task');
    // });
  }

  public function complete()
  {
    $this->update(['completed' => true]);
    
    $this->project->recordActivity('completed_task');
  }

  public function project()
  {
  	return $this->belongsTo(Project::class);
  }

  public function path()
  {
  	return "/projects/{$this->project->id}/tasks/{$this->id}";
  }
}
