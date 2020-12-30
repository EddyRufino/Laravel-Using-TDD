<x-app-layout>

	<div class="flex align-items-center mb-3">
		<h1 class="mr-auto">List Projects</h1>
		<a href="{{ route('projects.create') }}">New Project</a>		
	</div>

	<div class="flex">
		@forelse ($projects as $project)
			<div class="bg-white mr-4 rounded shadow">
				<h3>{{ $project->title }}</h3>
				<p>{{ $project->description }}</p>
			</div>
		@empty
			<p>no projects yet.</p>
		@endforelse
	</div>

</x-app-layout>