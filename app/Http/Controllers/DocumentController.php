<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Vanguard\Student;
use Illuminate\Support\Facades\Storage;
use Vanguard\Document;

class DocumentController extends Controller
{

    /**
     * Display documents for a specific student.
     */
    public function index(Student $student)
    {
        // Load student with documents
        $student->load('documents');

        return view('students.document', compact('student'));
    }

    /**
     * Store a newly uploaded document for a student.
     */
    public function store(Request $request, Student $student)
    {
        $request->validate([
            'upload_file.*' => 'required|file',
            'file_name.*' => 'required|string',
        ]);

        if ($request->hasFile('upload_file')) {
            foreach ($request->file('upload_file') as $index => $file) {
                $path = Storage::disk('wasabi')->put('documents', $file);
                $student->documents()->create([
                    'file_name' => $request->file_name[$index] ?? 'other',
                    'upload_file' => $path,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Documents uploaded successfully!');
    }

    /**
     * Delete a specific document.
     */
    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        // Delete file from storage
        if (Storage::exists($document->upload_file)) {
            Storage::delete($document->upload_file);
        }

        // Delete record from database
        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }
}




