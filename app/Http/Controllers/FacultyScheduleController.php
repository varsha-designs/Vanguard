<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Vanguard\Student;
use Vanguard\Faculty;
use Vanguard\FacultySchedule;

class FacultyScheduleController extends Controller
{
    public function index()
{
    $schedules = FacultySchedule::with(['faculty', 'student'])->get();
    return view('faculty_schedules.index', compact('schedules'));
}

public function create()
{
    $faculties = Faculty::all();
    $students = Student::all();
    return view('faculty_schedules.create', compact('faculties', 'students'));
}

public function store(Request $request)
{
    $request->validate([
        'faculty_id' => 'required',
        'studentid' => 'required',
        'day'       => 'required',
        'date'      => 'required|date',
        'time'      => 'required',
    ]);

    FacultySchedule::create([
        'faculty_id' => $request->faculty_id,
        'studentid' => $request->studentid,
        'day'       => $request->day,
        'date'      => $request->date,
        'time'      => $request->time,

    ]);

    return redirect()->route('faculty_schedules.index')->with('success', 'Schedule created successfully!');
}

public function edit($id)
{
    $schedule = FacultySchedule::findOrFail($id);
    $faculties = Faculty::all();
    $students = Student::all();
    return view('faculty_schedules.edit', compact('schedule', 'faculties', 'students'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'faculty_id' => 'required',
        'studentid' => 'required',
        'day'       => 'required',
        'date'      => 'required|date',
        'time'      => 'required',
    ]);

    $schedule = FacultySchedule::findOrFail($id);
    $schedule->update([
        'faculty_id' => $request->faculty_id,
        'studentid' => $request->studentid,
        'day'       => $request->day,
        'date'      => $request->date,
        'time'      => $request->time,

    ]);

    return redirect()->route('faculty_schedules.index')->with('success', 'Schedule updated successfully!');
}

public function destroy($id)
{
    $schedule = FacultySchedule::findOrFail($id);
    $schedule->delete();

    return redirect()->route('faculty_schedules.index')->with('success', 'Schedule deleted successfully!');
}

}
