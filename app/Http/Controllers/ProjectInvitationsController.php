<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectInvitationRequest;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class ProjectInvitationsController extends Controller
{
	public function store(ProjectInvitationRequest $request, Project $project)
	{
		$user = User::whereEmail(request('email'))->first();

		$project->invite($user);

		return redirect($project->path());
	}
}
