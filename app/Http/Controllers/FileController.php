<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Vanguard\File;
use Illuminate\Support\Facades\Auth;


class FileController extends Controller
{
     public function showUploadForm() {
        return view('files.upload'); // Blade file for uploading
    }

    public function upload(Request $request) {
        $request->validate([
            'file' => 'required|file|max:5120', // max 5MB
        ]);

        $uploadedFile = $request->file('file');
        $path = $uploadedFile->store('uploads');

        File::create([
            'file_name' => $uploadedFile->getClientOriginalName(),
            'file_path' => $path,
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->route('files.upload')->with('success', 'File uploaded successfully!');
    }

    public function history() {
        $files = File::where('uploaded_by', Auth::id())->latest()->get();
        return view('files.history', compact('files')); // Blade file for history
    }
}
