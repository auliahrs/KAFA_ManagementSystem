@extends('../master/kafa')
@section('content')
    <div class="container mt-3">
        <h3 class="mb-4">Timetable for Classroom: {{ $timetable->classroom->classroomName }}</h3>
        
        <!-- Display timetable data -->
        {{-- <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center bg-secondary">Time</th>
                    <th class="text-center bg-secondary">Monday</th>
                    <th class="text-center bg-secondary">Tuesday</th>
                    <th class="text-center bg-secondary">Wednesday</th>
                    <th class="text-center bg-secondary">Thursday</th>
                    <th class="text-center bg-secondary">Friday</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table> --}}
        {{-- <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center bg-secondary">Time</th>
                    <th class="text-center bg-secondary">Day</th>
                    <th class="text-center bg-secondary">Subject</th>
                    <th class="text-center bg-secondary">Teacher</th>
                </tr>
            </thead>
            <tbody>
                @if($timetableData)
                    @foreach ($timetableData as $data)
                        <tr>
                            <td class="text-center">{{ $data['time'] }}</td>
                            <td class="text-center">{{ $data['weekday'] }}</td>
                            <td class="text-center">{{ $data['subject'] }}</td>
                            <td class="text-center">{{ $data['teacher'] }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">No timetable entries found.</td>
                    </tr>
                @endif
            </tbody>
        </table> --}}
        {{-- <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center bg-secondary">Time</th>
                    <th class="text-center bg-secondary">Monday</th>
                    <th class="text-center bg-secondary">Tuesday</th>
                    <th class="text-center bg-secondary">Wednesday</th>
                    <th class="text-center bg-secondary">Thursday</th>
                    <th class="text-center bg-secondary">Friday</th>
                </tr>
            </thead>
            <tbody>
                @foreach (['08:30 - 09:00', '09:00 - 09:30', '09:30 - 10:00', '10:00 - 10:30', '10:30 - 11:00', '11:00 - 11:30'] as $timeSlot)
                    <tr>
                        <td class="text-center">{{ $timeSlot }}</td>
                        @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                            <td class="text-center">
                                @if ($day == 'monday' && $timeSlot == '10:00 - 10:30')
                                    <strong>Recess</strong>
                                @else
                                    @php
                                        $subjectEntry = collect($timetableData[$day])->firstWhere('time', $timeSlot);
                                    @endphp
                                    @if ($subjectEntry)
                                        {{ $subjectEntry['subject'] }}<br>
                                        <small class="text-muted">{{ $subjectEntry['teacher'] }}</small>
                                    @else
                                        -
                                    @endif
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table> --}}
        {{-- <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center bg-secondary">Time</th>
                    @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                    <th class="text-center bg-secondary">{{ Str::title($day) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($timetableData as $row)
                <tr>
                    <td class="text-center">{{ $row['time'] }}</td>
                    @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                    <td class="text-center">{!! ($row[$day]) !!}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table> --}}
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center bg-secondary">Time</th>
                    @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                        <th class="text-center bg-secondary">{{ Str::title($day) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($timetableData as $row)
                    <tr>
                        <td class="text-center">{{ $row['time'] }}</td>
                        @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                            <td class="text-center">{!! ($row[$day]) !!}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
