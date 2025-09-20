<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Vanguard\Faculty;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faculties = Faculty::all();
        return view('faculties.index', compact('faculties'));
    }

    public function create()
    {
        return view('faculties.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'faculty_id' => 'required|unique:faculties',
            'name' => 'required|string|max:255',
            'email_id' => 'required|email|unique:faculties',
            'phone_number' => 'required|string|max:20',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
        ]);

       Faculty::create([
    'faculty_id'   => $request->faculty_id,
    'name'         => $request->name,
    'email_id'     => $request->email_id,
    'phone_number' => $request->phone_number,
    'father_name'  => $request->father_name,
    'mother_name'  => $request->mother_name,
]);

        return redirect()->route('faculties.index')
                         ->with('success','Faculty created successfully.');
    }

    public function show(Faculty $faculty)
    {
        return view('faculties.show', compact('faculty'));
    }

    public function edit(Faculty $faculty)
    {
        return view('faculties.edit', compact('faculty'));
    }

    public function update(Request $request, Faculty $faculty)
    {
        $request->validate([
            'faculty_id' => 'required|unique:faculties,faculty_id,'.$faculty->id,
            'name' => 'required|string|max:255',
            'email_id' => 'required|email|unique:faculties,email_id,'.$faculty->email_id,
            'phone_number' => 'required|string|max:20',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
        ]);

      Faculty::update([
    'faculty_id'   => $request->faculty_id,
    'name'         => $request->name,
    'email_id'     => $request->email_id,
    'phone_number' => $request->phone_number,
    'father_name'  => $request->father_name,
    'mother_name'  => $request->mother_name,
]);

        return redirect()->route('faculties.index')
                         ->with('success','Faculty updated successfully.');
    }

    public function destroy(Faculty $faculty)
    {
        $faculty->delete();
        return redirect()->route('faculties.index')
                         ->with('success','Faculty deleted successfully.');
    }
}
