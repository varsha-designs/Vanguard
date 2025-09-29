<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Vanguard\StudentSchedule;
use Vanguard\Student;


class StudentScheduleController extends Controller
{
     public function index()
    {
        $schedules = StudentSchedule::with(['student'])->get();
        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $students = Student::all();
        return view('schedules.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'studentid' => 'required',
            'day' => 'required',
            'date' => 'required|date',
            'time' => 'required',
        ]);

     StudentSchedule::create([
        'studentid' => $request->studentid,
        'day'        => $request->day,
        'date'       => $request->date,
        'time'       => $request->time,
    ]);

        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully!');
    }
    public function edit($id)
{
    $schedule = StudentSchedule::findOrFail($id);
    $students = Student::all();

    return view('schedules.edit', compact('schedule', 'students'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'studentid' => 'required',
        'day'       => 'required',
        'date'      => 'required|date',
        'time'      => 'required',
    ]);

    // Find the record
    $schedule = StudentSchedule::findOrFail($id);

    // Update the record on the instance
    $schedule->update([
        'studentid' => $request->studentid,
        'day'       => $request->day,
        'date'      => $request->date,
        'time'      => $request->time,
    ]);


    return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully!');
}
public function destroy( $id){
   $schedule = StudentSchedule::findOrFail($id);
    $schedule->delete();

    return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully!');
}

}
