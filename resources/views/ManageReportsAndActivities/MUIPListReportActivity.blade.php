@extends('../master/muip')
@section('content')
    <table class="table table-success rounded-4 w-100">
        <thead class="table-secondary">
            <tr>
                <th scope="col" class="text-start px-5">Activity</th>
                <th scope="col" class="text-start">Status</th>
                <th scope="col" class="text-center" style="width: 200px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $activity)
                <tr>
                    <td class="px-5">{{ $activity->activityName }}</td>
                    <td>{{ $activity->status }}</td>
                    <td class="text-center">
                        <a href="{{ route('muip.viewReportActivity', $activity->id) }}"><i class="fas fa-eye mx-2"
                                title="View"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
