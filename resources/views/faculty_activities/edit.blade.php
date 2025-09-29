@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Edit Daily Activity (Faculty)</h1>

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('faculty_activities.update', $activity->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Faculty Dropdown -->
        <div class="mb-3">
            <label class="form-label fw-bold">Faculty</label>
            <select name="faculty_id" class="form-control" required>
                <option value="">Select Faculty</option>
                @foreach($faculties as $faculty)
                    <option value="{{ $faculty->id }}"
                        {{ $activity->faculty_id == $faculty->id ? 'selected' : '' }}>
                        {{ $faculty->name }} ({{ $faculty->id }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label fw-bold">In Time</label>
                <input type="time" name="in_time" class="form-control" value="{{ old('in_time', $activity->in_time) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Out Time</label>
                <input type="time" name="out_time" class="form-control" value="{{ old('out_time', $activity->out_time) }}">
            </div>
            <div class="col-md-4" style="display: none;">
                <label class="form-label fw-bold">Hours Spent</label>
                <input type="text" class="form-control" value="{{ old('in_time', $activity->in_time) }} hrs" >
            </div>
        </div>

        <!-- Time Slots Activities -->
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
                    <input type="text" name="activities[{{ $slot }}]" class="form-control"
                           value="{{ $activity->activities[$slot] ?? '' }}"
                           placeholder="Enter activity done in this hour">
                </div>
            @endforeach

            <!-- Extra Time -->
            <div class="input-group mb-2">
                <span class="input-group-text">Extra Time</span>
                <input type="text" name="activities[Extra Time]" class="form-control"
                       value="{{ $activity->activities['Extra Time'] ?? '' }}"
                       placeholder="Activities done in extra time">
            </div>
        </div>

        <!-- New Learning -->
        <div class="mb-3">
            <label class="form-label fw-bold">New Learning</label>
            <textarea name="new_learning" class="form-control" rows="3" placeholder="What you learned today">{{ old('new_learning', $activity->new_learning) }}</textarea>
        </div>

        <!-- To-Do List -->
        <div class="mb-3">
            <label class="form-label fw-bold">To-Do List</label>
            <textarea name="todo_list" class="form-control" rows="3" placeholder="Tasks to complete tomorrow or pending tasks">{{ old('todo_list', $activity->todo_list) }}</textarea>
        </div>

        <!-- Images Upload -->
        <div id="images-wrapper" class="mb-3">
            <label class="form-label fw-bold">Upload Images</label>

            <!-- Existing images -->
            @if(!empty($activity->images))
                <div class="mb-2 flex flex-wrap gap-2">
                    @foreach($activity->images as $index => $img)
                        <div class="relative w-24 h-24 border rounded-lg overflow-hidden">
                            <img src="{{ Storage::disk('wasabi')->temporaryUrl($img, now()->addMinutes(10)) }}"
                                 class="w-full h-full object-cover"
                                 alt="Activity Image">
                            <button type="button"
                                    class="absolute top-0 right-0 bg-red-500 text-white px-1 rounded remove-existing-image"
                                    data-index="{{ $index }}">X</button>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Add new images -->
            <div class="flex gap-2 mb-2">
                <input type="file" name="images[]" class="form-control">
                <button type="button" onclick="addImageInput()" class="btn btn-success mt-2">+ Add More</button>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-sm py-2">Update</button>
    </form>
</div>

<script>
document.addEventListener("click", function(e) {
    if (e.target.classList.contains("remove-image-input")) {
        e.target.parentElement.remove();
    }
    if (e.target.classList.contains("remove-existing-image")) {
        let index = e.target.dataset.index;
        e.target.parentElement.remove();
        let wrapper = document.getElementById('images-wrapper');
        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'remove_images[]';
        input.value = index;
        wrapper.appendChild(input);
    }
});

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
