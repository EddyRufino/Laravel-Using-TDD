	<div class="field">
		<label class="label" for="title">Title</label>

		<div class="control">
			<input
				type="text" 
				value="{{ old('title', $project->title) }}" 
				class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full" name="title" 
				placeholder="Title"
				required
			>
		</div>
	</div>

	<div class="field">
		<label class="label" for="description">Description</label>

		<div class="control">
			<textarea
				class="textarea bg-transparent border border-grey-light rounded p-2 text-xs w-full" 
				name="description"
				rows="10"
				required
			>
				{{ old('description', $project->description) }}
			</textarea>
		</div>
	</div>

	<div class="field">
		<div class="control">

			<button type="submit" class="button is-link">
				{{ $btn }}
			</button>

			<a href="{{ $project->path() }}">Projects</a>

		</div>
	</div>

	@if ($errors->any())
		<div class="field mt-6">
			@foreach ($errors->all() as $error)
				<li class="text-sm text-red">{{ $error }}</li>
			@endforeach
		</div>
	@endif