@extends('tabs.index')

@section('tab-content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Student Info</h2>
    <script src="https://cdn.tailwindcss.com"></script>

    <ul class="divide-y divide-gray-200">
        @foreach ($students as $student)
            <li class="py-3 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ $student->full_name }}</p>
                    <p class="text-sm text-gray-500">{{ $student->email }}</p>
                </div>
                <a href="{{ route('tabs.student-show', $student->id) }}"
                   class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                    View →
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
