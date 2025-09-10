@extends('layouts.sidebar')

@section('page-title', 'Upload File')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-6">Upload a File</h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('files.upload.post') }}" method="POST" enctype="multipart/form-data" class="flex space-x-4">
        @csrf
        <input type="file" name="file" required
               class="border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-400">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow-md">
            Upload
        </button>
    </form>
</div>
@endsection
