@extends('tabs.index')

@section('tab-content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Recent Activities</h2>
<script src="https://cdn.tailwindcss.com"></script>
    <ul class="divide-y divide-gray-200">
        @foreach ($activities as $activity)
            <li class="py-3 flex items-center justify-between">
                <div>
                     <p class="text-sm font-medium text-gray-900">{{ $activity->student->full_name }}</p>
                    <p class="text-sm font-medium text-gray-900">{{ $activity->activities }}</p>
                    <p class="text-sm text-gray-500">{{ $activity->created_at->format('d M Y') }}</p>
                </div>
                <a href="{{ url('daily-activities/' . $activity->id) }}"
                   class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                    Details →
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
