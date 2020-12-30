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
        // auth()->id() != $project->owner_id
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        return view('projects.show', compact('project'));
    }

    public function store(Request $request)
    {
    	$data = request()->validate([
    		'title' => 'required',
    		'description' => 'required'
    	]);

        auth()->user()->projects()->create($data);
    	
    	return redirect('projects');
    }
}
