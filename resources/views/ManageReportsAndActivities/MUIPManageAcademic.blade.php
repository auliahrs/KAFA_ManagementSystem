@extends('../master/muip')
@section('content')
    <table class="table table-success rounded-4 w-100">
        <thead class="table-secondary">
            <tr>
                <th scope="col" class="text-start px-5">Class Name</th>
                <th scope="col" class="text-center" style="width: 200px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($classrooms as $classroom)
                <tr>
                    <td class="px-5">{{ $classroom->classroomYear }} {{ $classroom->classroomName }}</td>
                    <td class="text-center">
                        <a href="{{ route('muip.classAcademicReport', $classroom->id) }}"><i class="fas fa-eye mx-2"
                                title="View"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
