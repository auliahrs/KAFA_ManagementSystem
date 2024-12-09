@extends('../master/kafa')
@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0 text-dark">New Activity</h5>
            </div>
            <div class="card-body">
                <!-- Form to Create New Activity -->
                <form action="{{ route('kafa.storeActivity') }}" method="POST">
                    @csrf
                    <input type="hidden" name="kafa_id" value="{{ auth()->user()->id }}">
                     <!-- Activity Name -->
                    <div class="row mb-3">
                        <label for="activityName" class="col-sm-2 col-form-label text-center">Activity Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="activityName" class="form-control" id="activityName" value="">
                        </div>
                    </div>
                     <!-- Venue -->
                    <div class="row mb-3">
                        <label for="venue" class="col-sm-2 col-form-label text-center">Venue</label>
                        <div class="col-sm-10">
                            <input type="text" name="venue" class="form-control" id="venue" value="">
                        </div>
                    </div>
                     <!-- Date and Time -->
                    <div class="row mb-3">
                        <label for="dateStart" class="col-sm-2 col-form-label text-center">Date</label>
                        <div class="col-sm-4">
                            <input type="date" name="dateStart" class="form-control" id="dateStart" value="">
                            <label for="dateEnd" class="col-sm-12 col-form-label text-center">Until</label>
                            <input type="date" name="dateEnd" class="form-control" id="dateEnd" value="">
                        </div>
                        <label for="timeStart" class="col-sm-2 col-form-label text-center">Time</label>
                        <div class="col-sm-4">
                            <input type="time" name="timeStart" class="form-control" id="timeStart" value="">
                            <label for="timeEnd" class="col-sm-12 col-form-label text-center">Until</label>
                            <input type="time" name="timeEnd" class="form-control" id="timeEnd" value="">
                        </div>
                    </div>
                    <!-- Attendees -->
                    <div class="row mb-3">
                        <label for="attendees" class="col-sm-2 col-form-label text-center">Attendees</label>
                        <div class="col-sm-10">
                            <input type="text" name="attendees" class="form-control" id="attendees" value="">
                        </div>
                    </div>
                    <!-- People In Charge -->
                    <div class="row mb-3">
                        <label for="organizerName" class="col-sm-2 col-form-label text-center">People In Charge</label>
                        <div class="col-sm-10">
                            <input type="text" name="organizerName" class="form-control" id="organizerName" value="">
                        </div>
                    </div>
                    <!-- Description -->
                    <div class="row mb-3">
                        <label for="description" class="col-sm-2 col-form-label text-center">Description</label>
                        <div class="col-sm-10">
                            <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="row">
                        <div class="col-sm-12 d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="{{ route('kafa.manageActivity') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
