@extends('../master/kafa')
@section('content')
	<div class="container mt-1">
		<h3 class="mb-4">Timetable</h3>

		<form method="POST" action="{{ route('timetable.store') }}">
			@csrf
			<div class="form-group d-flex justify-content-between">
				<div class="flex-grow-1 mr-2">
					<label for="teacherSelect" style="margin-left: 10px">Select Teacher:</label>
					<select id="teacherSelect" name="teacher_id" class="form-control" style="width:50%; margin-left: 10px">
						@foreach ($teachers as $teacher)
							<option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
						@endforeach
					</select>
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
							<td><select name="monday_7_30" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
							<td><select name="monday_8_30" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
							<td>B</td>
							<td><select name="monday_8_30" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
							<td><select name="monday_10_30" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
							<td><select name="monday_11_30" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
						</tr>
						<tr>
							<td>Tuesday</td>
							<td><select name="tuesday_7_30" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
							<td><select name="tuesday_8_30" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
							<td>R</td>
							<td><select name="tuesday_8_30" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
							<td><select name="tuesday_10_30" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
							<td><select name="tuesday_11_30" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
						</tr>
						<tr>
							<td>Wednesday</td>
							<td><select name="wednesday_7_30" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
							<td><select name="wednesday_8_30" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
							<td>E</td>
							<td><select name="wednesday_10_00" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
							<td><select name="wednesday_10_30" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
							<td><select name="wednesday_11_00" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
						</tr>
						<tr>
							<td>Thursday</td>
							<td><select name="thursday_7_30" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
							<td><select name="thursday_8_30" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
							<td>A</td>
							<td><select name="thursday_10_00" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
							<td><select name="thursday_10_30" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
							<td><select name="thursday_11_00" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
						</tr>
						<tr>
							<td>Friday</td>
							<td><select name="friday_7_30" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
							<td><select name="friday_8_30" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
							<td>K</td>
							<td><select name="friday_10_00" class="form-control">
									<option value="">Select Subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
									@endforeach
								</select></td>
                <td></td>
                <td></td>
						</tr>


					</tbody>
				</table>

				<div class="d-flex justify-content-end mt-2">
					<button type="submit" class="btn btn-primary mr-2">Save</button>
					<button onclick="window.location.href='{{ route('kafa.viewTimetable') }}'" type="button" class="btn btn-danger">Cancel</button>
				</div>
			</div>
		</form>
	</div>

	<!-- Add Bootstrap and jQuery JS -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
		integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
