@extends('../master/muip')
@section('content')
    <div class="row mb-3 me-3">
        <label for="studentName" class="col-sm-2 col-form-label text-center">Name</label>
        <div class="col-sm-4">
            <input type="text" readonly class="form-control" id="studentName" value="{{ $student->studentName }}">
        </div>
        <label for="classroom" class="col-sm-2 col-form-label text-center">Class</label>
        <div class="col-sm-4">
            <input type="text" readonly class="form-control" id="classroom" value="{{ $classroom->classroomName }}">
        </div>
    </div>
    <div class="row mb-3 me-3">
        <label for="gender" class="col-sm-2 col-form-label text-center">Gender</label>
        <div class="col-sm-2">
            <input type="text" readonly class="form-control" id="gender" value="{{ $student->gender }}">
        </div>
        <label for="icNum" class="col-sm-2 col-form-label text-center">Ic Number</label>
        <div class="col-sm-2">
            <input type="text" readonly class="form-control" id="icNum" value="{{ $student->icNum }}">
        </div>
        <label for="age" class="col-sm-2 col-form-label text-center">Age</label>
        <div class="col-sm-2">
            <input type="text" readonly class="form-control" id="age" value="{{ $student->age }}">
        </div>
    </div>

    <table class="table table-success rounded-4 w-100">
        <thead class="table-secondary">
            <tr>
                <th scope="col" class="text-start px-5">Subject</th>
                <th scope="col" class="text-start">Marks</th>
                <th scope="col" class="text-center" style="width: 200px;">Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subjects as $subject)
                <tr>
                    <td class="px-5">{{ $subject->subjectName }}</td>
                    @php
                        $result = $results->get($subject->id);
                    @endphp
                    <td>{{ $result ? $result->marks : 'N/A' }}</td>
                    <td class="text-center">{{ $result ? $result->grade : 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
