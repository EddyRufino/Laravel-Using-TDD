<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<h1>List Projects</h1>
	@forelse ($projects as $project)
		<li>
			<a href="{{ $project->path() }}">{{ $project->title }}</a>
		</li>
	@empty
		<p>no projects yet.</p>
	@endforelse
</body>
</html>