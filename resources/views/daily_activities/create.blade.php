@extends('layouts.app')

@section('content')
<div class="container my-5 p-4 bg-white shadow rounded">
    <h2 class="mb-4 text-2xl font-bold text-center">Add Daily Activity</h2>

    <form action="{{ route('daily_activities.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Student Dropdown -->
        <div class="mb-3">
            <label class="form-label fw-bold">Student</label>
            <select name="student_id" class="form-control" required>
                <option value="">Select Student</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->full_name }} ({{ $student->id }})</option>
                @endforeach
            </select>
        </div>

        <!-- Faculty Dropdown -->
        <div class="mb-3">
            <label class="form-label fw-bold">Faculty</label>
            <select name="faculty_id" class="form-control" required>
                <option value="">Select Faculty</option>
                @foreach($faculties as $faculty)
                    <option value="{{ $faculty->id }}">{{ $faculty->name }} ({{ $faculty->id }})</option>
                @endforeach
            </select>
        </div>

        <!-- Date -->
        <div class="mb-3">
            <label class="form-label fw-bold">Date</label>
            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        <!-- In Time -->
        <div class="mb-3">
            <label class="form-label fw-bold">In Time</label>
            <input type="time" name="in_time" class="form-control" required>
        </div>

        <!-- Out Time -->
        <div class="mb-3">
            <label class="form-label fw-bold">Out Time</label>
            <input type="time" name="out_time" class="form-control" required>
        </div>


        <!-- Activities -->
        <div id="activities-container" class="mb-3">
            <label class="form-label fw-bold">Activities</label>
            <div class="input-group mb-2">
                <input type="text" name="activities[]" class="form-control" placeholder="Enter activity" required>
                <button type="button" class="btn btn-success add-activity">+</button>
            </div>
        </div>
        <div id="images-wrapper" class="mb-3">
    <label>Upload Images</label>
    <div class="flex gap-2 mb-2">
        <input type="file" name="images[]" class="form-control">
        <button type="button" onclick="addImageInput()" class="btn btn-success mt-2">+ Add More</button>
    </div>
</div>


        <button type="submit" class="btn btn-primary btn-sm py-2">Save</button>
    </form>
</div>

<script>
document.addEventListener("click", function(e) {
    // 1️⃣ Add new activity input
    if (e.target.classList.contains("add-activity")) {
        let container = document.getElementById("activities-wrapper");

        let div = document.createElement("div");
        div.classList.add("input-group", "mb-2");
        div.innerHTML = `
            <input type="text" name="activities[]" class="form-control" placeholder="Enter activity" required>
            <button type="button" class="btn btn-danger remove-activity">X</button>
        `;
        container.appendChild(div);
    }

    // 2️⃣ Remove activity input
    if (e.target.classList.contains("remove-activity")) {
        e.target.parentElement.remove();
    }

    // 3️⃣ Remove image input
    if (e.target.classList.contains("remove-image-input")) {
        e.target.parentElement.remove();
    }
});

// 4️⃣ Function to add new image input
function addImageInput() {
    let wrapper = document.getElementById('images-wrapper');

    let div = document.createElement('div');
    div.classList.add('input-group', 'mb-2');

    div.innerHTML = `
        <input type="file" name="images[]" class="form-control">
        <button type="button" class="btn btn-danger remove-image-input">X</button>
    `;

    wrapper.appendChild(div);
}
</script>

@endsection
