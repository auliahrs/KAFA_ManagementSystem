@extends('../master/teacher')
@section('content')

<body>
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <form method="GET" action="{{ route('teacher.filterResult') }}">
                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                <div class="row">
                    
                        
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            Name:
                                        </div>
                                        <div class="col-md-6">
                                            {{$student->studentName}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            Year:
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-select form-select-sm" name="year" id="year">
                                                @foreach ($resultsAll->pluck('year')->unique() as $year)
                                                <option value="{{$year}}">{{$year}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                        </div>
                                        <div class="col-md-6">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            Standard / Class:
                                        </div>
                                        <div class="col-md-6">
                                            {{$classroom->classroomName}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            Type of Examination:
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-select form-select-sm" name="typeOfExamination" id="typeOfExamination">
                                                @foreach ($resultsAll->pluck('typeOfExamination')->unique() as $tOE)
                                                <option value="{{$tOE}}">{{$tOE}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">

                                        </div>
                                        <div class="col-md-6 text-end">
                                            <button class="btn btn-success mx-1">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-success rounded-4 w-100">
                    <thead class="table-secondary">
                        <tr>
                            <th scope="col">Subject</th>
                            <th scope="col">Marks</th>
                            <th scope="col">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                            <tr>
                                <td>
                                    @php
                                        $subject = \App\Models\Subject::find($result->subject_id);
                                    @endphp
                                    {{ $subject->subjectName }}
                                </td>
                                <td>
                                    {{$result->marks}}
                                </td>
                                <td>
                                    {{$result->grade}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>Rank in the class: </p>
                <p>Rank in standard: </p>
                <p>Total Marks: </p>
                <p>Percentage: </p>
            </div>
        </div>
    </div>
    <!-- Add Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</body>
</html>

@endsection