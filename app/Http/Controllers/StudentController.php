<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Vanguard\Student;
use Illuminate\Support\Facades\Storage;
use Vanguard\Document;



class StudentController extends Controller
{
     public function index()
    {
        $students = Student::all(); // fetch all students
        return view('students.index', compact('students'));
    }

    // 2. Show create form
    public function create()
    {
        return view('students.create');
    }

    // 3. Store new student
    public function store(Request $request)
{
    // 1️⃣ Validate input
    $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|unique:students,email',
        'whatsapp_number' => 'required|string|max:20',
        'dob' => 'required|date',
        'gender' => 'required|string',
        'address' => 'required|string',
        'college' => 'required|string',
        'degree' => 'required|string',
        'year_of_passing' => 'required|string',
        'company' => 'required|string',
        'role' => 'required|string',
        'experience' => 'required|string',
        'upload_file.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf', // multiple files
        'file_name.*' => 'nullable|string', // only save file names
    ]);

    // 2️⃣ Create student record
    $student = Student::create([
        'full_name' => $request->full_name,
        'email' => $request->email,
        'whatsapp_number' => $request->whatsapp_number,
        'dob' => $request->dob,
        'gender' => $request->gender,
        'address' => $request->address,
        'college' => $request->college,
        'degree' => $request->degree,
        'year_of_passing' => $request->year_of_passing,
        'company' => $request->company,
        'role' => $request->role,
        'experience' => $request->experience,
    ]);

        return redirect()->route('students.index')->with('success', 'Student created successfully!');
    }
   // Show edit form
public function edit(Student $student)
{
    return view('students.edit', compact('student'));
}

// Handle update
public function update(Request $request, Student $student)
{
    $student->update($request->only([
        'full_name', 'email', 'whatsapp_number', 'dob',
        'gender', 'address', 'college', 'degree',
        'year_of_passing', 'company', 'role', 'experience'
    ]));

    // Save new documents if uploaded

    if ($request->hasFile('upload_file')) {
        foreach ($request->file('upload_file') as $index => $file) {
            if ($file) {
              $path = Storage::disk('wasabi')->put('documents', $file);
               $student->documents()->create([
                    'file_name' => $request->file_name[$index] ?? 'other',
                    'upload_file' => $path,
                ]);
            }
        }
    }

    return redirect()->route('students.index')->with('success', 'Student updated successfully!');
}
public function destroyDocument($id)
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
