@extends('../master/kafa')
@section('content')
	<div class="container">
		<h3>Create Timetable</h3>

			<div class="card mb-3">
				<div class="card-body">
					<form action="{{ isset($timetable) ? route('timetable.update', $timetable->id) : route('timetable.save') }}" method="{{ isset($timetable) ? 'POST' : 'POST' }}" class="row g-3">
						@csrf
						@if (isset($timetable))
							@method('PUT')
						@endif
			
						<div>
							<p><b>Please enter the timetable details.</b></p>
						</div>
			
						@if ($errors->any())
							<div class="alert alert-danger">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
			
						<div class="row mb-4">
							<div class="col-md-4">
								<label for="classroom_id" class="form-label">Classroom</label>
								<select class="form-select" name="classroom_id">
									<option value="" selected>Select classroom</option>
									@foreach ($classes as $class)
										<option value="{{ $class->id }}" {{ isset($timetable) && $timetable->classroom_id == $class->id ? 'selected' : '' }}>
											{{ $class->id }} - {{ Str::title($class->classroomName) }}
										</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-4">
								<label for="subject_id" class="form-label">Subject</label>
								<select class="form-select" name="subject_id">
									<option value="" selected>Select subject</option>
									@foreach ($subjects as $subject)
										<option value="{{ $subject->id }}" {{ isset($timetable) && $timetable->subject_id == $subject->id ? 'selected' : '' }}>
											{{ $subject->id }} - {{ Str::title($subject->subjectName) }}
										</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-4">
								<label for="teacher_id" class="form-label">Teacher</label>
								<select class="form-select" name="teacher_id">
									<option value="" selected>Select teacher</option>
									@foreach ($teachers as $teacher)
										<option value="{{ $teacher->id }}" {{ isset($timetable) && $timetable->teacher_id == $teacher->id ? 'selected' : '' }}>
											{{ $teacher->id }} - {{ Str::title($teacher->user->name) }}
										</option>
									@endforeach
								</select>
							</div>
						</div>
			
						<div class="row mb-4">
							<div class="col-md-4">
								<label for="weekday" class="form-label">Day</label>
								<select class="form-select" name="weekday">
									<option value="" selected>Select weekday</option>
									@foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $weekday)
										<option value="{{ $weekday }}" {{ isset($timetable) && $timetable->weekday == $weekday ? 'selected' : '' }}>
											{{ Str::title($weekday) }}
										</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-4">
								<label for="start_time" class="form-label">Choose start time</label>
								{{-- <select class="form-select" name="start_time">
									<option value="" selected>Select start time</option>
									@foreach (['08:30', '09:00', '09:30', '10:30', '11:00'] as $time)
										<option value="{{ $time }}" {{ isset($timetable) && $timetable->start_time == $time ? 'selected' : '' }}>
											{{ $time }}
										</option>
									@endforeach
								</select> --}}
								<select class="form-select" name="start_time">
									<option value="" selected>Select start time</option>
									@foreach (['08:30', '09:00', '09:30', '10:30', '11:00'] as $time)
										<option value="{{ $time }}" {{ isset($timetable) && \Carbon\Carbon::parse($timetable->start_time)->format('H:i') == $time ? 'selected' : '' }}>
											{{ $time }}
										</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-4">
								<label for="end_time" class="form-label">Choose end time</label>
								{{-- <select class="form-select" name="end_time">
									<option value="" selected>Select end time</option>
									@foreach (['09:00', '09:30', '10:00', '11:00', '11:30'] as $time)
										<option value="{{ $time }}" {{ isset($timetable) && $timetable->end_time == $time ? 'selected' : '' }}>
											{{ $time }}
										</option>
									@endforeach
								</select> --}}
								<select class="form-select" name="end_time">
									<option value="" selected>Select end time</option>
									@foreach (['09:00', '09:30', '10:00', '11:00', '11:30'] as $time)
										<option value="{{ $time }}" {{ isset($timetable) && \Carbon\Carbon::parse($timetable->end_time)->format('H:i') == $time ? 'selected' : '' }}>
											{{ $time }}
										</option>
									@endforeach
								</select>
							</div>
						</div>
			
						<div class="mb-3">
							<a href="{{ route('timetable.save') }}" class="btn btn-danger">Cancel</a>
							<button type="submit" class="btn btn-success">Save</button>
						</div>
					</form>
				</div>
			</div>
			

			{{-- <div class="form-group d-flex justify-content-between">
				<div class="flex-grow-1 mr-2">
					<label for="teacherSelect" style="margin-left: 10px">Select Teacher:</label>
					<select name="staff_id" class="form-control" style="width:50%; margin-left: 10px">
						@foreach ($teachers as $teacher)
							<option value="{{ $teacher->staff_id }}">{{ $teacher->staff_id }} - {{ $teacher->user->name }}</option>
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
			</div> --}}
		{{-- </form> --}}
	</div>

	<!-- Add Bootstrap and jQuery JS -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
@endsection
