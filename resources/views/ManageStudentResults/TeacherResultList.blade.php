@extends('../master/teacher')
@section('content')

<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <h1 class="mb-4">Student Results</h1>
    <table class="table table-success rounded-4 w-100">
        <thead class="table-secondary">
            <tr>
                <th scope="col" class="text-center" style="width: 50px;">No</th>
                <th scope="col" class="text-start">Name</th>
                <th scope="col" class="text-center" style="width: 450px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
                <tr>
                    <td>
                        <div class="d-flex justify-content-center mt-2">
                            {{ $index + 1 }}
                        </div>
                    </td>
                    <td>
                        <div class="mt-2">
                            {{ $student->studentName }}
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-link mx-1"><a href="{{ route('teacher.addResult',['studentID' => $student->id]) }}"><i class="fas fa-plus me-2"></i>Add results</a>
                            
                            </button>
                            <button class="btn btn-link mx-1"><a href="{{ route('teacher.editResult',['studentID' => $student->id]) }}"><i class="fa-solid fa-pen-to-square me-2"></i>Edit</button>
                            <button class="btn btn-link mx-1"><a href="{{ route('teacher.viewResult',['studentID' => $student->id]) }}"><i class="fas fa-eye me-2"></i>View</button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Bootstrap and jQuery JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@endsection