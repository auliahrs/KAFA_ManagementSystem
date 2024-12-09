@extends('../master/muip')
@section('content')
    <div>
        <canvas id="averageResultChart" width="400" height="200"></canvas>
    </div>

    <table class="table table-success rounded-4 w-100">
        <thead class="table-secondary">
            <tr>
                <th scope="col" class="text-start px-5">No</th>
                <th scope="col" class="text-start">Student Name</th>
                <th scope="col" class="text-center" style="width: 200px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td class="px-5">{{ $loop->iteration }}</td>
                    <td class="text-start">{{ $student->studentName }}</td>
                    <td class="text-center">
                        <a href="{{ route('muip.studentAcademicReport',  ['student' => $student->id, 'classroom' => $classroom->id]) }}"><i class="fas fa-eye mx-2"
                                title="View"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('averageResultChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($studentNames),
                datasets: [{
                    label: 'Average Result',
                    data: @json($averageResults),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
