<x-app-layout>
	<header class="lg:flex items-center mb-3 py-4">
		<div class="lg:flex justify-between items-end w-full">
			<p class="mr-auto text-grey text-sm font-normal mb-3 md:mb-0">
				<a href="{{ route('projects') }}">My Projects</a> / {{ $project->title }}
			</p>
			<a href="{{ route('projects.create') }}"
				class="button" 
			>
				New Project
			</a>
		</div>
	</header>

	<div class="lg:flex -mx-3">
		<div class="lg:w-3/4 px-3 mb-6">
			<div class="mb-8">
				<h2 class="text-lg text-grey font-normal mb-3">Tasks</h2>

				@foreach ($project->tasks as $task)
					<div class="card mb-3">
						<form action="{{ $task->path() }}" 
							method="POST"
						>
							@method('PATCH')
							@csrf

							<div class="flex">
								<input
									name="body"
									value="{{ $task->body }}"
									class="w-full {{ $task->completed ? 'text-grey' : '' }}"
								>
								<input
									type="checkbox"
									name="completed"
									onChange="this.form.submit()"
									{{ $task->completed ? 'checked' : '' }}
								>
							</div>

						</form>
							
					</div>
				@endforeach

				<div class="card mb-3">
					<form action="{{ $project->path() . '/tasks' }}" method="POST">
						@csrf
						
						<input placeholder="Add new task..." class="w-full" name="body">
						
					</form>
				</div>
			</div>

			<div>
				<h2 class="text-lg text-grey font-normal mb-3">General Notes</h2>
				<textarea class="card w-full" style="min-height: 200px">
					Lorem Ipsum.
				</textarea>
			</div>
		</div>

		<div class="lg:w-1/4 px-3">
			@include('projects.card')
		</div>
	</div>
	
	
	
	
</x-app-layout>