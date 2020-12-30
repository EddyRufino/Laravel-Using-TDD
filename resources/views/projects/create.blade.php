<x-app-layout>

<div class="lg:w-1/2 lg:mx-auto bg-card p-6 md:py-12 md:px-16 rounded shadow">
  <h1 class="text-2xl font-normal mb-10 text-center">
     Let's start something new
  </h1>

  
	<form method="POST" action="/projects">
		@csrf

		<div class="field">
			<label class="label" for="title">Title</label>

			<div class="control">
				<input type="text" class="input" name="title" placeholder="Title">
			</div>
		</div>

		<div class="field">
			<label class="label" for="description">Description</label>

			<div class="control">
				<textarea class="textarea" name="description"></textarea>
			</div>
		</div>

		<div class="field">
			<div class="control">
				<button type="submit" class="button is-link">Create Project</button>
				<a href="{{ route('projects') }}">Projects</a>
			</div>
		</div>
	</form>
</div>
</x-app-layout>