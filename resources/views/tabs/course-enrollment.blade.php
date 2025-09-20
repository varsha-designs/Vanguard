@extends('tabs.index')

@section('tab-content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Course Enrollments</h2>
<script src="https://cdn.tailwindcss.com"></script>
    <ul class="divide-y divide-gray-200">
        @foreach ($courses as $course)
            <li class="py-3 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ $course->course_name }}</p>
                    <p class="text-sm text-gray-500">Start Date: {{ $course->start_date }} </p>
                    <p class="text-sm text-gray-500">Enrolled Students: {{ $course->students_count }}
                    </p>
                </div>
                <a href="{{ url('courses/' . $course->id) }}"
                   class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                    View →
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
