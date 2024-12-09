@extends('../master/kafa')
@section('content')
	<div class="container mt-1">
		<h3 class="mb-4">Timetable</h3>

		<div class="form-group d-flex justify-content-between">
			<div class="flex-grow-1 mr-2">
				<label for="teacherSelect" style="margin-left: 10px">Select Teacher:</label>
				<select id="teacherSelect" class="form-control" style="width:50%; margin-left: 10px">
					@foreach ($teachers as $teacher)
						<option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="align-self-end">
                <button onclick="window.location.href='{{ route('kafa.addTimetable') }}'" id="addTeacher" class="btn btn-primary mt-2">Add</button>
            </div>
		</div>

		<div class="timetable">

			<table class="table table-bordered text-center mt-4">
				<thead class="thead-light">
					<tr>
						<th></th>
						<th>7:30am - 8:30am</th>
						<th>8:30am - 9:30am</th>
						<th>9:30am - 10:00am</th>
						<th>10:00am - 10:30am</th>
						<th>10:30am - 11:00am</th>
						<th>11:00am - 11:30am</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Monday</td>
						<td></td>
						<td></td>
						<td>B</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>

					<tr>
						<td>Tuesday</td>
						<td></td>
						<td></td>
						<td>R</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>

					<tr>
						<td>Wednesday</td>
						<td></td>
						<td></td>
						<td>E</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>

					<tr>
						<td>Thursday</td>
						<td></td>
						<td></td>
						<td>A</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>

					<tr>
						<td>Friday</td>
						<td></td>
						<td></td>
						<td>K</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>

				</tbody>
			</table>

            <div class="d-flex justify-content-end mt-2">
				<button onclick="window.location.href='{{ route('kafa.editTimetable') }}'"id="editTimetable" class="btn btn-primary">Edit</button>
                <button id="deleteTimetable" class="btn btn-danger">Delete</button>
			</div>
 
		</div>
	</div>

	<!-- Add Bootstrap and jQuery JS -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
		integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
