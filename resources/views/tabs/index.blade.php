
@extends('layouts.app')

@section('content')
<div class="p-6">
     <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Student Details</h1>
        <a href="{{ route('tabs.id-card') }}"
    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-500 transition">
    ID Card
</a>

    </div>
     <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
            <a href="{{ route('tabs.profile') }}"
               class="whitespace-nowrap py-4 px-1 border-b-2  text-sm font-medium {{ request()->is('tabs/profile') ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 ' }}">
                Profile
            </a>
            <a href="{{ route('tabs.courseEnrollment') }}"
               class="whitespace-nowrap py-4 px-1 border-b-2 text-sm font-medium {{ request()->is('tabs/course-enrollment') ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 ' }}">
                Course Enrollment
            </a>
            <a href="{{ route('tabs.activities') }}"
               class="whitespace-nowrap py-4 px-1 border-b-2 text-sm font-medium {{ request()->is('tabs/activities') ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 ' }}">
                Activities
            </a>
            <a href="{{ route('tabs.photos') }}"
               class="whitespace-nowrap py-4 px-1 border-b-2 text-sm font-medium {{ request()->is('tabs/photos') ? 'border-indigo-600 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 ' }}">
                Photos
            </a>


        </nav>
    </div>

    <!-- Tab Content -->
    <div class="mt-6">
        @yield('tab-content')
    </div>
</div>

@endsection
