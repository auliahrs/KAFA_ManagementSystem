@extends('../master/teacher')
@section('content')

<body>
    
    <div class="container mt-5">
        <form action="{{ route('teacher.storeResult') }}" method="POST">
            @csrf
            <input type="hidden" name="studentId" value="{{$student->id}}">
        <div class="row">
            <div class="col-md-12">
                
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
                                                @for ($year = 2020; $year <= date('Y'); $year++)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endfor
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
                                                
                                                <option value="Mid-year Examination">Mid-year Examination</option>
                                                <option value="Final-year Examination">Final-year Examination</option>
                                                
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
                        @if ($mode != 0) 
                            @foreach($results as $result)
                                <tr>
                                    <td>
                                        @php
                                            $subjectEdit = \App\Models\Subject::find($result->subject_id);
                                        @endphp
                                        {{ $subjectEdit->subjectName }}
                                    </td>
                                    <td>
                                        <input type="number" name="marks[{{ $subjectEdit->id }}]" value="{{ $result->marks }}" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="text" name="grades[{{ $subjectEdit->id }}]" value="{{ $result->grade }}" class="form-control" readonly>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @foreach ($subjects as $subject)
                                <tr>
                                    <td>
                                        {{ $subject->subjectName }}
                                    </td>
                                    <td>
                                        <input type="number" name="marks[{{ $subject->id }}]" value="" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="text" name="grades[{{ $subject->id }}]" value="" class="form-control" readonly>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row pb-3">
            <div class="col-md-3">
                <label for="comments">Teacher's Comments:</label>
            </div>
            <div class="col-md-6">
                <textarea name="comments" class="form-control" rows="3" required></textarea>
            </div>
            <div class="col-md-3 text-bottom">
                @if ($mode == 0)
                    <button type="submit" class="btn btn-success">Submit</button><a href="{{route('teacher.listStudent')}}" class="btn btn-danger">Cancel</a>
                @else  
                    <input type=hidden name="edit" value="edit" />
                    <button type="submit" class="btn btn-success">Submit</button><a href="{{route('teacher.listStudent')}}" class="btn btn-danger">Cancel</a>
                @endif
            </div>
        </div>
    </form>
    </div>
    <!-- Add Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</body>
</html>

@endsection