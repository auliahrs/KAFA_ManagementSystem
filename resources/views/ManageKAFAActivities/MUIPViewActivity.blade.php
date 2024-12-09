@extends('../master/muip')
@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                 <!-- Activity Name -->
                <h5 class="mb-0">{{$activity->activityName}}</h5>
            </div>
            <div class="card-body">
                 <!-- Form Start -->
                <form>
                     <!-- Activity Name Field -->
                    <div class="row mb-3">
                        <label for="activityName" class="col-sm-2 col-form-label text-center">Activity Name</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" id="activityName"
                                value="{{$activity->activityName}}">
                        </div>
                    </div>
                       <!-- Venue Field -->
                    <div class="row mb-3">
                        <label for="venue" class="col-sm-2 col-form-label text-center">Venue</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" id="venue" value="{{$activity->venue}}">
                        </div>
                    </div>
                       <!-- Date and Time Fields -->
                    <div class="row mb-3">
                        <label for="dateStart" class="col-sm-2 col-form-label text-center">Date</label>
                        <div class="col-sm-4">
                            <input type="date" readonly class="form-control" id="dateStart" value="{{$activity->dateStart}}">
                            <label for="dateEnd" class="col-sm-12 col-form-label text-center">Until</label>
                            <input type="date" readonly class="form-control" id="dateEnd" value="{{$activity->dateEnd}}">
                        </div>
                        <label for="timeStart" class="col-sm-2 col-form-label text-center">Time</label>
                        <div class="col-sm-4">
                            <input type="time" readonly class="form-control" id="timeStart" value="{{$activity->timeStart}}">
                            <label for="timeEnd" class="col-sm-12 col-form-label text-center">Until</label>
                            <input type="time" readonly class="form-control" id="timeEnd" value="{{$activity->timeEnd}}">
                        </div>
                    </div>
                      <!-- Attendees Field -->
                    <div class="row mb-3">
                        <label for="attendees" class="col-sm-2 col-form-label text-center">Attendees</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" id="attendees"
                                value="{{$activity->attendees}}">
                        </div>
                    </div>
                     <!-- People In Charge Field -->
                    <div class="row mb-3">
                        <label for="organizerName" class="col-sm-2 col-form-label text-center">People In Charge</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" id="organizerName"
                                value="{{$activity->organizerName}}">
                        </div>
                    </div>
                        <!-- Description Field -->
                    <div class="row mb-3">
                        <label for="description" class="col-sm-2 col-form-label text-center">Description</label>
                        <div class="col-sm-10">
                            <textarea readonly class="form-control" id="description" rows="3">{{$activity->description}}</textarea>
                        </div>
                    </div>
                         <!-- Feedback Field -->
                    <div class="row mb-3">
                        <label for="feedback" class="col-sm-2 col-form-label text-center">Feedback</label>
                        <div class="col-sm-10">
                            <textarea readonly class="form-control" id="feedback" rows="3">{{$activity->feedback}}</textarea>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <form method="GET" action="{{ route('muip.manageActivity') }}">
                        <div class="col-sm-10 offset-sm-2">
                            <button type="submit" class="btn btn-danger">Back</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
