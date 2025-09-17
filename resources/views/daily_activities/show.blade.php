@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2>Activity Details</h2>

    <ul class="list-group mb-4">
        <li class="list-group-item"><strong>Student:</strong> {{ $dailyActivity->student->full_name ?? $dailyActivity->student_id ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>Faculty:</strong> {{ $dailyActivity->faculty->name ?? $dailyActivity->faculty_id ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>Date:</strong> {{ $dailyActivity->date }}</li>
        <li class="list-group-item"><strong>In Time:</strong> {{ $dailyActivity->in_time }}</li>
        <li class="list-group-item"><strong>Out Time:</strong> {{ $dailyActivity->out_time }}</li>
        <li class="list-group-item"><strong>Hours Spent:</strong> {{ $dailyActivity->hours_spent ?? '0' }}</li>
        <li class="list-group-item">
            <strong>Activities:</strong>
            <ul class="list-unstyled mt-2 mb-0">
                @foreach(json_decode($dailyActivity->activities, true) ?? [] as $act)
                    <li>- {{ $act }}</li>
                @endforeach
            </ul>


    <li class="list-group-item">
        <strong>Existing Images:</strong>
        <div class="flex gap-3 mt-2 flex-wrap">
            @forelse($dailyActivity->images as $image)
                <img src="{{ $image->signed_url }}"
                     class="w-32 h-32 object-cover rounded border"
                     alt="Activity Image">
            @empty
                <p class="text-gray-500">No images uploaded.</p>
            @endforelse
        </div>
    </li>
</ul>

    <div class="mt-3">
        <a href="{{ route('daily_activities.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('daily_activities.edit', $dailyActivity->id) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection
