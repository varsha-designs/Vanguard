@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-10 space-y-8">
 <script src="https://cdn.tailwindcss.com"></script>

  {{-- Back Button --}}
       <div class="flex justify-start mt-4">
    <a href="{{ route('tabs.profile') }}"
       class="px-6 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition">
       ← Back
    </a>
</div>

        {{-- Student Info --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Student Details</h2>
            <h1 class="text-xl  text-gray-800 mb-2">{{ $student->full_name }}</h1>
            <p class="text-gray-600">Email: {{ $student->email }}</p>
            <p class="text-gray-600">ID: {{ $student->id }}</p>
        </div>

        {{-- Enrolled Courses --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">📘 Enrolled Courses</h2>
            @forelse($courses as $course)
                <p class="border-b py-2">{{ $course->course_name }}</p>
            @empty
                <p class="text-gray-500">This student has not enrolled in any courses.</p>
            @endforelse
        </div>

        {{-- Activities --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">📝 Activities</h2>
            <p class="font-medium text-gray-700 mb-3">
                Total: {{ $activities->count() }} activities
            </p>
            <ul class="list-disc list-inside space-y-2">
                @foreach($activities as $activity)
                    <li class="text-gray-700">{{ $activity->activities }}</li>
                @endforeach
            </ul>
            @if($activities->isEmpty())
                <p class="text-gray-500">No activities found for this student.</p>
            @endif
        </div>

        {{-- Uploaded Photos --}}
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">📷 Uploaded Documents</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                     @forelse($documents as $doc)
                    @if($doc->signed_url)
                        <div class="border rounded overflow-hidden relative group">
                            <img src="{{ $doc->signed_url }}"
                                 alt="Photo of {{ $student->full_name }}"
                                 class="w-full h-32 object-cover">

                            <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                <a href="{{ $doc->signed_url }}" target="_blank" class="text-white font-semibold px-2 py-1 bg-indigo-600 rounded">View</a>
                            </div>
                        </div>
                    @endif

                @empty
                    <p class="text-gray-500 col-span-2">No photos uploaded for this student.</p>
                @endforelse
            </div>
        </div>

<div class="bg-white rounded-2xl shadow p-6">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">📷 Activity Images</h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @forelse($activities as $activity)
            @foreach($activity->validImages ?? [] as $image)
                @if($image->signed_url)
                    <div class="border rounded overflow-hidden relative group">
                        <img src="{{ $image->signed_url }}"
                             alt="Activity image for {{ $student->full_name }}"
                             class="w-full h-32 object-cover">

                        <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <a href="{{ $image->signed_url }}" target="_blank" class="text-white font-semibold px-2 py-1 bg-indigo-600 rounded">View</a>
                        </div>
                    </div>
                @endif
            @endforeach
        @empty
            <p class="text-gray-500 col-span-2">No images for this student’s activities.</p>
        @endforelse
    </div>
</div>



  </div>
@endsection
