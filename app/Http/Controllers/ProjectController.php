<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
	public function index()
	{
		$projects = Project::all();

		return view('projects.index', compact('projects'));
	}

    public function store(Request $request)
    {
    	$data = request()->validate([
    		'title' => 'required',
    		'description' => 'required',
    	]);

    	$project = Project::create($data);
    	
    	return redirect('projects');
    }
}
