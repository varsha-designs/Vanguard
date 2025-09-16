@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Edit Daily Activity</h1>

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('daily_activities.update', $dailyActivity->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- 1. General Details -->
        <div class="card mb-4">
            <div class="card-header">General Details</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Student</label>
                        <select name="student_id" class="form-control" required>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ $dailyActivity->student_id == $student->id ? 'selected' : '' }}>
                                    {{ $student->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Faculty</label>
                        <select name="faculty_id" class="form-control" required>
                            @foreach($faculties as $faculty)
                                <option value="{{ $faculty->id }}" {{ $dailyActivity->faculty_id == $faculty->id ? 'selected' : '' }}>
                                    {{ $faculty->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" value="{{ $dailyActivity->date }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">In Time</label>
                        <input type="time" name="in_time" value="{{ $dailyActivity->in_time }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Out Time</label>
                        <input type="time" name="out_time" value="{{ $dailyActivity->out_time }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Hours Spent</label>
                        <input type="text" name="hours_spent" value="{{ $dailyActivity->hours_spent }}" class="form-control" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Activities -->
        <div class="card mb-4">
            <div class="card-header">Activities</div>
            <div class="card-body">
                <div id="activities-wrapper" class="space-y-3">
                    @foreach(json_decode($dailyActivity->activities, true) as $act)
                        <div class="input-group mb-2">
                            <input type="text" name="activities[]" value="{{ $act }}" class="form-control" required>
                            <button type="button" onclick="this.parentNode.remove()" class="btn btn-danger">X</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" onclick="addActivity()" class="btn btn-success mt-2">+ Add More</button>
            </div>
        </div>

        <div class="mb-5">
            <button type="submit" class="btn btn-primary">Update Activity</button>
            <a href="{{ route('daily_activities.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
function addActivity() {
    let wrapper = document.getElementById('activities-wrapper');
    let div = document.createElement('div');
    div.classList.add('input-group','mb-2');
    div.innerHTML = `
        <input type="text" name="activities[]" class="form-control" required>
        <button type="button" onclick="this.parentNode.remove()" class="btn btn-danger">X</button>
    `;
    wrapper.appendChild(div);
}
</script>
@endsection
