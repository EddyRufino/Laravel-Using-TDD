<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
	public function index()
	{
		$projects = auth()->user()->projects;

		return view('projects.index', compact('projects'));
	}

    public function create(Project $project)
    {
        return view('projects.create', compact('project'));
    }

    public function show(Project $project)
    {
        // auth()->id() != $project->owner_id --> this, inside if

        // if (auth()->user()->isNot($project->owner)) { --> or this
        //     abort(403);
        // }
        $this->authorize('update', $project); // ot this

        return view('projects.show', compact('project'));
    }

    public function store(Request $request)
    {
    	$data = $this->validateRequest();

        $project = auth()->user()->projects()->create($data);
    	
    	return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);

        $project->update($this->validateRequest());

        return redirect($project->path());
    }

    public function validateRequest()
    {
        return request()->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'min:3'
        ]);
    }
}
