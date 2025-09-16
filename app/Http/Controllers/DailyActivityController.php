<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Vanguard\DailyActivity;
use Vanguard\Student;
use Vanguard\Faculty;
use  Carbon\carbon;

class DailyActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        // Get all activities with student & faculty details
        $activities = DailyActivity::with(['student', 'faculty'])->latest()->get();
        return view('daily_activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch students & faculties for dropdown
        $students = Student::all();
        $faculties = Faculty::all();

        return view('daily_activities.create', compact('students', 'faculties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id'   => 'required|exists:students,id',
            'faculty_id'   => 'required|exists:faculties,id',
            'date'         => 'required|date',
            'in_time'      => 'required',
            'out_time'     => 'required|after:in_time',
            'activities'   => 'required|array|min:1',
            'activities.*' => 'required|string',
        ]);

        DailyActivity::create([
            'student_id' => $request->student_id,
            'faculty_id' => $request->faculty_id,
             'date'      => $request->date ?? now()->toDateString(),
            'in_time'    => $request->in_time,
            'out_time'   => $request->out_time,
            'activities' => json_encode($request->activities), // store as JSON
        ]);

        return redirect()->route('daily_activities.index')->with('success', 'Daily Activity created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyActivity $dailyActivity, $id)
    {
        $dailyActivity = DailyActivity::with(['student','faculty'])->findOrFail($id);
        return view('daily_activities.show', compact('dailyActivity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyActivity $dailyActivity , $id)
    {
        $students = Student::all();
        $faculties = Faculty::all();
          $dailyActivity = DailyActivity::findOrFail($id);

        return view('daily_activities.edit', compact('dailyActivity', 'students', 'faculties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DailyActivity $dailyActivity, $id)
    {
         $dailyActivity = DailyActivity::findOrFail($id);

        $request->validate([
            'student_id'   => 'required|exists:students,id',
            'faculty_id'   => 'required|exists:faculties,id',
            'date'         => 'required|date',
            'in_time'      => 'required',
            'out_time'     => 'required|after:in_time',
            'activities'   => 'required|array|min:1',
            'activities.*' => 'required|string',
        ]);


        $dailyActivity->update([
            'student_id' => $request->student_id,
            'faculty_id' => $request->faculty_id,
             'date'       => $request->date ?? $dailyActivity->date ?? now()->toDateString(),
            'in_time'    => $request->in_time,
            'out_time'   => $request->out_time,
            'activities' => json_encode($request->activities),
        ]);


        return redirect()->route('daily_activities.index')->with('success', 'Daily Activity updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyActivity $dailyActivity)
    {
        $dailyActivity->delete();
        return redirect()->route('daily_activities.index')->with('success', 'Daily Activity deleted successfully.');
    }

}
