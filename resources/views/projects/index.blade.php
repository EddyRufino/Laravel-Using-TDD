<x-app-layout>

<div id="modal">
	<header class="flex items-center mb-3 py-4">
		<h1 class="mr-auto text-grey text-sm font-normal">
			List Projects
		</h1>
		<a href="{{ route('projects.create') }}"
			class="button"
			@click.prevent="$modal.show('new-project')"
		>
			New Project
		</a>		
	</header>

	<div class="lg:flex lg:flex-wrap -mx-3">
		@forelse ($projects as $project)
			<div class="lg:w-1/3 px-3 pb-6">
				@include('projects.card')
			</div>
		@empty
			<p>no projects yet.</p>
		@endforelse
	</div>


{{-- 	<div id="app">
		<a href="" @click.prevent="$modal.show('test')">test</a>
		<modal name="test">
		   My test
		</modal>
		
	</div> --}}

	<new-project-modal></new-project-modal>
</div>
</x-app-layout>