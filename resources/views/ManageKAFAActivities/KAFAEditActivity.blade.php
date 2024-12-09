@extends('../master/kafa')
@section('content')

    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">{{$activity->activityName}}</h5>
            </div>
            <div class="card-body">
                  <!-- Form to Update Activity -->
                <form action="{{ route('kafa.updateActivity', $activity->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                      <!-- Activity Name -->
                    <div class="row mb-3">
                        <label for="activityName" class="col-sm-2 col-form-label text-center">Activity Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="activityName" class="form-control" id="activityName" value="{{$activity->activityName}}">
                        </div>
                    </div>
                        <!-- Venue -->
                    <div class="row mb-3">
                        <label for="venue" class="col-sm-2 col-form-label text-center">Venue</label>
                        <div class="col-sm-10">
                            <input type="text" name="venue" class="form-control" id="venue" value="{{$activity->venue}}">
                        </div>
                    </div>
                        <!-- Date and Time -->
                    <div class="row mb-3">
                        <label for="dateStart" class="col-sm-2 col-form-label text-center">Date</label>
                        <div class="col-sm-4">
                            <input type="date" name="dateStart" class="form-control" id="dateStart" value="{{$activity->dateStart}}">
                            <label for="dateEnd" class="col-sm-12 col-form-label text-center">Until</label>
                            <input type="date" name="dateEnd" class="form-control" id="dateEnd" value="{{$activity->dateEnd}}">
                        </div>
                        <label for="timeStart" class="col-sm-2 col-form-label text-center">Time</label>
                        <div class="col-sm-4">
                            <input type="time" name="timeStart" class="form-control" id="timeStart" value="{{$activity->timeStart}}">
                            <label for="timeEnd" class="col-sm-12 col-form-label text-center">Until</label>
                            <input type="time" name="timeEnd" class="form-control" id="timeEnd" value="{{$activity->timeEnd}}">
                        </div>
                    </div>
                        <!-- Attendees -->
                    <div class="row mb-3">
                        <label for="attendees" class="col-sm-2 col-form-label text-center">Attendees</label>
                        <div class="col-sm-10">
                            <input type="text" name="attendees" class="form-control" id="attendees" value="{{$activity->attendees}}">
                        </div>
                    </div>
                        <!-- People In Charge -->
                    <div class="row mb-3">
                        <label for="organizerName" class="col-sm-2 col-form-label text-center">People In Charge</label>
                        <div class="col-sm-10">
                            <input type="text" name="organizerName" class="form-control" id="organizerName" value="{{$activity->organizerName}}">
                        </div>
                    </div>
                        <!-- Description -->
                    <div class="row mb-3">
                        <label for="description" class="col-sm-2 col-form-label text-center">Description</label>
                        <div class="col-sm-10">
                            <textarea name="description" class="form-control" id="description" rows="3">{{$activity->description}}</textarea>
                        </div>
                    </div>
                        <!-- Feedback -->
                    <div class="row mb-3">
                        <label for="feedback" class="col-sm-2 col-form-label text-center">Feedback</label>
                        <div class="col-sm-10">
                            <textarea name="feedback" class="form-control" id="feedback" rows="3">{{$activity->feedback}}</textarea>
                        </div>
                    </div>
                        <!-- Submit Button -->
                    <div class="row">
                        <div class="col-sm-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary mx-2">Submit</button>
                            <a href="{{ route('kafa.manageActivity') }}" class="btn btn-secondary mx-2">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
