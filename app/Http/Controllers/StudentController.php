<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Vanguard\Student;



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

        // Validate the form
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
            'upload_file' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'file_name' => 'required|string',
        ]);

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('upload_file')) {
            $filePath = $request->file('upload_file')->store('student_id', 'wasabi');
        }

        // Save to database
        $student= Student::create([
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
      $student->documents()->create([
        'file_name' => $request->file_name,
        'upload_file' => $filePath,
    ]);

        return redirect()->route('students.index')->with('success', 'Student created successfully!');
    }
}
