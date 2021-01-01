<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectTaskController extends Controller
{
  public function store(Project $project)
  {
  	request()->validate(['body' => 'required']);

  	$project->addTask(request('body'));

  	return redirect($project->path());
  }
}
