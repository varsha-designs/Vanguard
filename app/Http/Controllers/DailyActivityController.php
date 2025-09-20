<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Vanguard\DailyActivity;
use Vanguard\Student;
use Vanguard\Faculty;
use Vanguard\ActivityImage;
use Illuminate\Support\Facades\Storage;


class DailyActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = DailyActivity::with(['student', 'faculty'])->latest()->get();
        return view('daily_activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
           'out_time' => 'required|only after:'.$request->in_time,
           'out_time.after' => 'Out time must be later than In time.',
            'activities'   => 'required|array|min:1',
            'activities.*' => 'required|string',
            'images.*'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
        ]);

        $activity = DailyActivity::create([
            'student_id' => $request->student_id,
            'faculty_id' => $request->faculty_id,
            'date'       => $request->date ?? now()->toDateString(),
            'in_time'    => $request->in_time,
            'out_time'   => $request->out_time,
            'activities' => json_encode($request->activities),

        ]);

        // Store new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
              $path = $image->store('access_test', 'wasabi', ['visibility' => 'private']);
                $activity->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('daily_activities.index')->with('success', 'Daily Activity created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $dailyActivity = DailyActivity::with('images','student.courses')->findOrFail($id);

    /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
    $disk = Storage::disk('wasabi');
     foreach ($dailyActivity->images as $img) {
            // Generate a temporary signed URL valid for 10 minutes
            $img->signed_url = Storage::disk('wasabi')->exists($img->image_path)
                ? $disk->temporaryUrl($img->image_path, now()->addMinutes(1))
                : null;
        }


    return view('daily_activities.show', compact('dailyActivity'));
}

// AJAX route to fetch courses of a student
public function getStudentCourses($studentId)
{
    $student = Student::with('courses')->findOrFail($studentId);
    return response()->json($student->courses);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $students = Student::all();
        $faculties = Faculty::all();
        $dailyActivity = DailyActivity::with('images')->findOrFail($id);

        return view('daily_activities.edit', compact('dailyActivity', 'students', 'faculties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $dailyActivity = DailyActivity::findOrFail($id);

        $request->validate([
            'student_id'   => 'required|exists:students,id',
            'faculty_id'   => 'required|exists:faculties,id',
            'date'         => 'required|date',
            'in_time'      => 'required',
           'out_time' => 'required|after:'.$request->in_time,
           'out_time.after' => 'Out time must be later than In time.', // custom message
            'activities'   => 'required|array|min:1',
            'activities.*' => 'required|string',
        ]);

        // Update main fields
        $dailyActivity->update([
            'student_id' => $request->student_id,
            'faculty_id' => $request->faculty_id,
            'date'       => $request->date ?? $dailyActivity->date ?? now()->toDateString(),
            'in_time'    => $request->in_time,
            'out_time'   => $request->out_time,
            'activities' => json_encode($request->activities),

        ]);

        // Delete selected images
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imgId) {
                $img = ActivityImage::find($imgId);
                if ($img) {
                    Storage::disk('wasabi')->delete($img->image_path);
                    $img->delete();
                }
            }
        }

        // Add new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('access_test', 'wasabi', ['visibility' => 'private']);
                $dailyActivity->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('daily_activities.index')->with('success', 'Daily Activity updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dailyActivity = DailyActivity::with('images')->findOrFail($id);

        foreach ($dailyActivity->images as $image) {
            Storage::disk('wasabi')->delete($image->image_path);
            $image->delete();
        }

        $dailyActivity->delete();

        return redirect()->route('daily_activities.index')->with('success', 'Daily Activity deleted successfully.');
    }
}
