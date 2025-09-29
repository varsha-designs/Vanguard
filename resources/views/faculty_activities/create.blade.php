@extends('layouts.app')

@section('content')
<div class="container my-5 p-4 bg-white shadow rounded">
    <h2 class="mb-4 text-2xl font-bold text-center">Add Daily Activity (Faculty)</h2>

    <form action="{{ route('faculty_activities.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 🔹 Faculty Dropdown -->
        <div class="mb-3">
            <label class="form-label fw-bold">Faculty</label>
            <select name="faculty_id" class="form-control" required>
                <option value="">Select Faculty</option>
                @foreach($faculties as $faculty)
                    <option value="{{ $faculty->id }}">{{ $faculty->name }} ({{ $faculty->id }})</option>
                @endforeach
            </select>
        </div>

        <!-- 🔹 In Time & Out Time -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">In Time</label>
                <input type="time" name="in_time" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Out Time</label>
                <input type="time" name="out_time" class="form-control" required>
            </div>
        </div>

        <!-- 🔹 Time slots 9AM-8PM -->
        <div id="time-slots-container" class="mb-3">
            <label class="form-label fw-bold">Time Slots Activities</label>

            @php
                $timeSlots = [
                     '10-11 AM', '11-12 PM', '12-1 PM', '1-2 PM',
                    '2-3 PM', '3-4 PM', '4-5 PM', '5-6 PM', '6-7 PM', '7-8 PM'
                ];
            @endphp

            @foreach($timeSlots as $slot)
                <div class="input-group mb-2">
                    <span class="input-group-text">{{ $slot }}</span>
                    <input type="text" name="activities[{{ $slot }}]" class="form-control" placeholder="Enter activity done in this hour">
                </div>
            @endforeach

            <!-- 🔹 Extra Time field -->
            <div class="input-group mb-2">
                <span class="input-group-text">Extra Time</span>
                <input type="text" name="activities[Extra Time]" class="form-control" placeholder="Activities done in extra time">
            </div>
        </div>

        <!-- 🔹 New Learning -->
        <div class="mb-3">
            <label class="form-label fw-bold">New Learning</label>
            <textarea name="new_learning" class="form-control" rows="3" placeholder="What new did you learn today?"></textarea>
        </div>

        <!-- 🔹 To-Do List -->
        <div class="mb-3">
            <label class="form-label fw-bold">To-Do List</label>
            <textarea name="todo_list" class="form-control" rows="3" placeholder="Tasks to complete tomorrow or pending tasks"></textarea>
        </div>

        <!-- 🔹 Images Upload -->
       <div id="images-wrapper" class="mb-3">
    <label class="form-label fw-bold">Upload Images</label>

    <!-- First image input -->
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
    // Remove image input dynamically
    if (e.target.classList.contains("remove-image-input")) {
        e.target.parentElement.remove();
    }
});

// Add new image input
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
