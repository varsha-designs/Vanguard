@extends('tabs.index')

@section('tab-content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Student Photos</h2>
<script src="https://cdn.tailwindcss.com"></script>
    @forelse($students as $student)
        <div class="mb-6 p-4 bg-gray-50 rounded-lg shadow-sm">
            <!-- Student Name -->
            <p class="text-sm font-medium text-gray-900 mb-2">{{ $student->full_name }}</p>

            <!-- Photos Grid -->
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4">
                @forelse($student->photos as $photo)
                    @if($photo->signed_url)
                        <div class="border rounded overflow-hidden relative group">
                            <img src="{{ $photo->signed_url }}"
                                 alt="Photo of {{ $student->full_name }}"
                                 class="w-full h-32 object-cover">

                            <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                <a href="{{ $photo->signed_url }}" target="_blank" class="text-white font-semibold px-2 py-1 bg-indigo-600 rounded">View</a>
                            </div>
                        </div>
                    @endif
                @empty
                    <p class="text-gray-500 text-sm col-span-full mt-2">No photos uploaded</p>
                @endforelse
            </div>
        </div>
    @empty
        <p class="text-gray-500">No students found.</p>
    @endforelse
</div>
@endsection

