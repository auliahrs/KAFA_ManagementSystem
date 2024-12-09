@extends('../master/muip')
@section('content')


<div class="d-flex justify-content-end mb-3">
    <form action="{{ route('muip.manageActivity') }}" method="GET" class="d-flex">
          <!-- Search Input -->
        <input type="text" name="search" class="form-control" placeholder="Search" aria-label="Search" value="{{ request('search') }}" />
         <!-- Search Button -->
        <button type="submit" class="btn btn-primary text-white btn-sm mx-3">Search</button>
    </form>
</div>

<!-- Table of Activities -->
<table class="table table-success rounded-4 w-100">
    <thead class="table-secondary">
        <tr>
             <!-- Column for Activity -->
            <th scope="col" class="text-start px-5">Activity</th>
             <!-- Column for Action -->
            <th scope="col" class="text-center" style="width: 200px;">Action</th>
        </tr>
    </thead>
    <tbody>
         <!-- Loop through Activities -->
        @forelse ($activities as $activity)
            <tr>
                 <!-- Display Activity Name -->
                <td class="px-5">{{ $activity->activityName }}</td>
                <td class="text-center">
                    <div class="btn-group" role="group">
                         <!-- View Button -->
                        <a href="{{ route('muip.viewActivity', $activity->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye" title="View"></i> View
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="text-center">No activities found</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection


