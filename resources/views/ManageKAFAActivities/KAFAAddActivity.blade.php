@extends('../master/kafa')
@section('content')

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0 text-dark">New Activity</h5>
        </div>
        <div class="card-body">
            <!-- Display Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form to Create New Activity -->
            <form id="activityForm" action="{{ route('kafa.storeActivity') }}" method="POST" novalidate>
                @csrf
                <input type="hidden" name="kafa_id" value="{{ auth()->user()->id }}">

                <!-- Activity Name -->
                <div class="row mb-3">
                    <label for="activityName" class="col-sm-2 col-form-label text-center">Activity Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="activityName" class="form-control" id="activityName" value="{{ old('activityName') }}" required>
                        @error('activityName')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Venue -->
                <div class="row mb-y3">
                    <label for="venue" class="col-sm-2 col-form-label text-center">Venue</label>
                    <div class="col-sm-10">
                        <input type="text" name="venue" class="form-control" id="venue" value="{{ old('venue') }}" required>
                        @error('venue')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Date and Time -->
                <div class="row mb-3">
                    <label for="dateStart" class="col-sm-2 col-form-label text-center">Date</label>
                    <div class="col-sm-4">
                        <input type="date" name="dateStart" class="form-control" id="dateStart" value="{{ old('dateStart') }}" required>
                        @error('dateStart')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <label for="dateEnd" class="col-sm-2 col-form-label text-center">Until</label>
                    <div class="col-sm-4">
                        <input type="date" name="dateEnd" class="form-control" id="dateEnd" value="{{ old('dateEnd') }}" required>
                        @error('dateEnd')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="timeStart" class="col-sm-2 col-form-label text-center">Time</label>
                    <div class="col-sm-4">
                        <input type="time" name="timeStart" class="form-control" id="timeStart" value="{{ old('timeStart') }}" required>
                        @error('timeStart')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <label for="timeEnd" class="col-sm-2 col-form-label text-center">Until</label>
                    <div class="col-sm-4">
                        <input type="time" name="timeEnd" class="form-control" id="timeEnd" value="{{ old('timeEnd') }}" required>
                        @error('timeEnd')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Attendees -->
                <div class="row mb-3">
                    <label for="attendees" class="col-sm-2 col-form-label text-center">Attendees</label>
                    <div class="col-sm-10">
                        <input type="text" name="attendees" class="form-control" id="attendees" value="{{ old('attendees') }}" required>
                        @error('attendees')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Organizer -->
                <div class="row mb-3">
                    <label for="organizerName" class="col-sm-2 col-form-label text-center">People In Charge</label>
                    <div class="col-sm-10">
                        <input type="text" name="organizerName" class="form-control" id="organizerName" value="{{ old('organizerName') }}" required>
                        @error('organizerName')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="row mb-3">
                    <label for="description" class="col-sm-2 col-form-label text-center">Description</label>
                    <div class="col-sm-10">
                        <textarea name="description" class="form-control" id="description" rows="3" required>{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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

<!-- Client-Side Validation Script -->
<script>
    document.getElementById('activityForm').addEventListener('submit', function (e) {
        let valid = true;
        const requiredFields = ['activityName', 'venue', 'dateStart', 'dateEnd', 'timeStart', 'timeEnd', 'attendees', 'organizerName', 'description'];

        requiredFields.forEach(function (field) {
            const input = document.getElementById(field);
            if (!input.value.trim()) {
                valid = false;
                input.classList.add('is-invalid');
                let errorText = input.nextElementSibling;
                if (!errorText) {
                    errorText = document.createElement('span');
                    errorText.classList.add('text-danger');
                    errorText.innerText = `Please enter ${field.replace(/([A-Z])/g, ' $1')}`;
                    input.parentNode.appendChild(errorText);
                }
            } else {
                input.classList.remove('is-invalid');
                const errorText = input.nextElementSibling;
                if (errorText && errorText.classList.contains('text-danger')) {
                    input.parentNode.removeChild(errorText);
                }
            }
        });

        if (!valid) {
            e.preventDefault(); // Prevent form submission if invalid
        }
    });
</script>
@endsection
