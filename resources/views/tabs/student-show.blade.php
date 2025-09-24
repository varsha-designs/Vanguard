@extends('tabs.index')

@section('content')
<div class="max-w-6xl mx-auto py-10">
 <script src="https://cdn.tailwindcss.com"></script>

    <!-- Profile -->
    @if($section == 'profile')
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">📋 Student Details</h2>
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <ul class="space-y-2 text-gray-700">
            <li><strong>ID:</strong> {{ $student->id }}</li>
            <li><strong>Student ID:</strong> {{ $student->studentid }}</li>
            <li><strong>Full Name:</strong> {{ $student->full_name }}</li>
            <li><strong>Email:</strong> {{ $student->email }}</li>
            <li><strong>WhatsApp:</strong> {{ $student->whatsapp_number }}</li>
            <li><strong>Date of Birth:</strong> {{ $student->dob }}</li>
            <li><strong>Gender:</strong> {{ $student->gender }}</li>
            <li><strong>Address:</strong> {{ $student->address }}</li>
            <li><strong>College:</strong> {{ $student->college }}</li>
            <li><strong>Degree:</strong> {{ $student->degree }}</li>
            <li><strong>Year of Passing:</strong> {{ $student->year_of_passing }}</li>
            <li><strong>Company:</strong> {{ $student->company }}</li>
            <li><strong>Role:</strong> {{ $student->role }}</li>
            <li><strong>Experience:</strong> {{ $student->experience }}</li>
        </ul>
    </div>
    @endif

    {{-- Section-based display --}}
    @if($section == 'courses')

 <h3 class="text-xl font-semibold mb-2">📚 Courses Enrolled</h3>
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <ul class="list-disc ml-6">
            @forelse($student->courses as $course)
              <p class="text-xl font-semibold text-gray-800 mb-2 ">
        {{ $student->full_name }}
              </p>
                <li>
                    {{ $course->course_name }} (Start: {{ $course->start_date }})
                </li>
            @empty
                <li>No courses enrolled</li>
            @endforelse
        </ul>
    </div>



    @elseif($section == 'activities')
     <h3 class="text-xl font-semibold mb-2">🎯 Activities</h3>
     <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <ul class="list-disc ml-6">
             <p class="text-xl font-semibold text-gray-800 mb-2 ">
        {{ $student->full_name }}
              </p>
            @forelse($student->dailyActivities as $activity)
                <li>{{ $activity->activities }}</li>
            @empty
                <li>No activities found</li>
            @endforelse
        </ul>
        </div>

 @elseif($section == 'photos')
    <h3 class="text-xl font-semibold mb-4">📸 Photos</h3>

    {{-- Student Document Images --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <h4 class="text-lg font-semibold mb-2">📂 Student Document Images</h4>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            @forelse($student->documents as $doc)
                @if($doc->signed_url)
                    <img src="{{ $doc->signed_url }}" class="w-full h-32 object-cover rounded">
                @endif
            @empty
                <p>No document images available</p>
            @endforelse
        </div>
    </div>

    {{-- Student Activity Images --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <h4 class="text-lg font-semibold mb-2">🎯 Student Activity Images</h4>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            @forelse($student->allPhotos as $img)
                @if($img->signed_url)
                    <img src="{{ $img->signed_url }}" class="w-full h-32 object-cover rounded">
                @endif
            @empty
                <p>No activity images available</p>
            @endforelse
        </div>
    </div>
@endif


</div>
@endsection
