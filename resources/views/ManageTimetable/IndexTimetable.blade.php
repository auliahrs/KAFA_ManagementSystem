@extends('../master/kafa')

@section('content')
	<div class="container mt-1">
		<h3 class="mb-4">List of Timetable</h3>
		@can('kafa')
			<a href="{{ route('timetable.create') }}" class="btn btn-primary mb-3">Create timetable</a>
		@endcan

		@forelse ($groupedTimetables as $classroomName => $timetables)
			<div class="d-flex justify-content-between align-items-center mb-2">
				<h4>{{ $classroomName }}</h4>
				<a href="{{ route('timetable.view', $timetables->first()->id) }}" class="btn btn-warning">View<i class="fa fa-eye" aria-hidden="true"></i></a>
			</div>
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th class="text-center bg-secondary">Id</th>
						<th class="text-center bg-secondary">Subject</th>
						@if (Auth::user()->role !== 'teacher')
						<th class="text-center bg-secondary">Teacher</th>
						@endif
						<th class="text-center bg-secondary">Day</th>
						<th class="text-center bg-secondary">Time</th>
						@can('kafa')
						<th class="text-center bg-secondary">Actions</th>
						@endcan
					</tr>
				</thead>
				<tbody>
					@foreach ($timetables as $timetable)
						<tr>
							<td class="text-center">{{ $timetable->id }}</td>
							<td class="text-center">{{ $timetable->subject->subjectName }}</td>
							@if (Auth::user()->role !== 'teacher')
								<td class="text-center">{{ $timetable->teacher->user->name }}</td>
							@endif
							<td class="text-center">{{ ucfirst($timetable->weekday) }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($timetable->start_time)->format('H:i') }}</td>
							@can ('kafa')
							<td class="text-center">
									<a href="{{ url('timetable/'.$timetable->id.'/update-timetable') }}" class="btn btn-info">Edit<i class="fa fa-edit" aria-hidden="true"></i></a>
										<form action="{{ route('timetable.delete', $timetable->id) }}" method="POST" style="display:inline;">
											@csrf
											@method('DELETE') <!-- Method spoofing for DELETE -->
											<button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this timetable?');">
												Delete<i class="fa fa-trash" aria-hidden="true"></i>
											</button>
										</form>
									</td>
							@endcan
						</tr>
					@endforeach
				</tbody>
			</table>
		@empty
			<p>No timetables available.</p>
		@endforelse
	</div>

	<!-- Add Bootstrap and jQuery JS -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
		integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
