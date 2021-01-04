<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  use HasFactory;

  protected $guarded = [];

  protected $touches = ['project']; // Actualizo una tarea this ayuda a ordenarla

  public function project()
  {
  	return $this->belongsTo(Project::class);
  }

  public function path()
  {
  	return "/projects/{$this->project->id}/tasks/{$this->id}";
  }
}
