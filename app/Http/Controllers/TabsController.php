<?php
namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Vanguard\Student;
use Vanguard\DailyActivity;
use Vanguard\Course;
use Vanguard\ActivityImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TabsController extends Controller
{
    // ------------------------
    // Show all students (Profile tab)
    // ------------------------
    public function profile()
    {
        $students = Student::all();
        return view('tabs.profile', compact('students'));
    }

    // ------------------------
    // Show all courses (Course Enrollment tab)
    // ------------------------
    public function courseEnrollment()
    {
        $students = Student::all(); // get all students
    return view('tabs.course-enrollment', compact('students'));
    }

    // ------------------------
    // Show all activities (Activities tab)
    // ------------------------
    public function activities()
    {
        $students = Student::all(); ;
        return view('tabs.activities', compact('students'));
    }



    // ------------------------
    // Show photos/documents (Documents tab)
    // ------------------------
    public function photos()
    {
        return view('tabs.photos', compact('students'));
    }


    // ------------------------
    // Show student details with courses & activities
    // ------------------------

public function showStudent($id, Request $request)
{
    $student = Student::with('dailyActivities.images', 'courses', 'documents')->findOrFail($id);
    $disk = Storage::disk('wasabi');

    // Ensure collections exist
    $activities = $student->dailyActivities ?? collect();
    $student->documents = $student->documents ?? collect();
    $student->courses   = $student->courses ?? collect();

    // ---------------------------
    // Activity Images
    // ---------------------------
    $activityImages = collect();
    foreach ($activities as $activity) {
        foreach ($activity->images as $img) {
            if ($disk->exists($img->image_path)) {
                // File exists → generate signed URL
                /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
                $img->signed_url = $disk->temporaryUrl($img->image_path, now()->addMinutes(10));
                $activityImages->push($img);
            } else {
                // File missing → delete DB record
                $img->delete();
            }
        }
    }

    // ---------------------------
    // Document Images (only image files)
    // ---------------------------
    /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */

    $documentImages = collect();
    foreach ($student->documents as $doc) {
        if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $doc->upload_file)) {
            if ($disk->exists($doc->upload_file)) {
                $doc->signed_url = $disk->temporaryUrl($doc->upload_file, now()->addMinutes(10));
                $documentImages->push($doc);
            } else {
                // File missing → delete DB record
                DB::table('documents')->where('id', $doc->id)->delete();
            }
        }
    }

    // ---------------------------
    // Merge activity & document images
    // ---------------------------
    $student->allPhotos = $activityImages->merge($documentImages);

    $section = $request->get('section', 'profile');

    return view('tabs.student-show', compact('student', 'activities', 'section'));
}

public function idCard(Request $request)
{
    // Always fetch all students for the dropdown
    $students = Student::all();

    // Initialize $student as null
    $student = null;

    // If a student ID is passed, fetch that student
    if ($request->has('id') && $request->id != '') {
        $student = Student::find($request->id);

        // Optional: handle case if student not found
        if (!$student) {
            return redirect()->route('tabs.id-card')->with('error', 'Student not found.');
        }
    }

    // Pass both $students and $student to the view
    return view('tabs.id-card', compact('students', 'student'));
}
}
