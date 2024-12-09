@extends('../master/kafa')
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
                        @if (!is_null($activity->feedback))
                        <a href="{{route('kafa.viewReportActivity', $activity->id)}}"><i class="fas fa-eye mx-2" title="View"></i></a>
                        @endif
                        
                        @if (is_null($activity->feedback))
                        <form method="GET" action="{{route('kafa.createReportActivity', $activity->id)}}">
                            <button type="submit" class="btn btn-primary text-white btn-sm">Create</button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
