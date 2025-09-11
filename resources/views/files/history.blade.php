@extends('layouts.sidebar')

@section('page-title', 'File History')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4">Uploaded Files History</h2>

    <ul class="divide-y divide-gray-200">
        @forelse($files as $file)
            <li class="py-3 flex justify-between items-center hover:bg-gray-50 px-3 rounded transition">
               <a href="{{ Storage::disk('wasabi')->url($file->file_path) }}"class="text-black-600 font-medium ">{{ $file->file_name }}</a>
                <span class="text-gray-500 text-sm">{{ $file->created_at->format('d M Y H:i') }}</span>
            </li>
        @empty
            <li class="py-2 text-gray-500">No files uploaded yet.</li>
        @endforelse
    </ul>
</div>
@endsection
