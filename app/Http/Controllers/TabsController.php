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
        $courses = Course::withCount('students')->get();
        return view('tabs.course-enrollment', compact('courses'));
    }

    // ------------------------
    // Show all activities (Activities tab)
    // ------------------------
    public function activities()
    {
        $activities = DailyActivity::with('student')->get();
        return view('tabs.activities', compact('activities'));
    }

    // ------------------------
    // Show activity photos (Activity Photos tab)
    // ------------------------
    public function activityPhotos($studentId)
    {
        $student = Student::findOrFail($studentId);

        $activities = DailyActivity::where('student_id', $studentId)
            ->with('images')
            ->get();

        $disk = Storage::disk('wasabi');
/** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        foreach ($activities as $activity) {
            foreach ($activity->images as $img) {
                $img->signed_url = $disk->exists($img->image_path)
                    ? $disk->temporaryUrl($img->image_path, now()->addMinutes(10))
                    : null;
            }
        }

        return view('tabs.activity-photos', compact('student', 'activities'));
    }

    // ------------------------
    // Upload activity images
    // ------------------------
    public function storeActivityImages(Request $request, $activityId)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $activity = DailyActivity::findOrFail($activityId);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('activity-images', 'wasabi');

                ActivityImage::create([
                    'activity_id' => $activity->id,
                    'image_path'  => $path,
                ]);
            }
        }

        return back()->with('success', 'Activity images uploaded successfully.');
    }

    // ------------------------
    // Delete an activity image
    // ------------------------
    public function destroyActivityImage($id)
    {
        $image = ActivityImage::findOrFail($id);
        $disk = Storage::disk('wasabi');

        if ($disk->exists($image->image_path)) {
            $disk->delete($image->image_path);
        }

        $image->delete();

        return back()->with('success', 'Activity image deleted successfully.');
    }

    // ------------------------
    // Show photos/documents (Documents tab)
    // ------------------------
    public function photos()
    {
        $students = Student::all();
        $disk = Storage::disk('wasabi');
/** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        foreach ($students as $student) {
            $student->documents = DB::table('documents')
                ->where('student_id', $student->id)
                ->select('id', 'upload_file')
                ->get()
                ->map(function ($doc) use ($disk) {
                    $doc->signed_url = $disk->exists($doc->upload_file)
                        ? $disk->temporaryUrl($doc->upload_file, now()->addMinutes(10))
                        : null;
                    return $doc;
                });
        }

        return view('tabs.photos', compact('students'));
    }

    // ------------------------
    // Delete a document
    // ------------------------
    public function deleteDocument($documentId)
    {
        $disk = Storage::disk('wasabi');
        $doc = DB::table('documents')->where('id', $documentId)->first();

        if ($doc && $disk->exists($doc->upload_file)) {
            $disk->delete($doc->upload_file);
        }

        DB::table('documents')->where('id', $documentId)->delete();

        return back()->with('success', 'Document deleted successfully.');
    }

    // ------------------------
    // Show student details with courses & activities
    // ------------------------
    public function showStudent($id)
    {
        // Load student with activities and their images
        $student = Student::with('dailyActivities.images')->findOrFail($id);
       $activities = $student->dailyActivities;

$disk = Storage::disk('wasabi');

foreach ($activities as $activity) {
    // Add a new property "validImages" to each activity
    /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
    $activity->validImages = $activity->images->filter(function($img) use ($disk) {
        $img->signed_url = $disk->exists($img->image_path)
            ? $disk->temporaryUrl($img->image_path, now()->addMinutes(10))
            : null;
        return $img->signed_url !== null; // only keep images with a valid signed URL
    });
}


        // Fetch student courses
        $courses = DB::table('enrollments')
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->where('enrollments.student_id', $id)
            ->select('courses.*')
            ->get();

        // Fetch student documents with signed URLs
        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $documents = DB::table('documents')
            ->where('student_id', $id)
            ->select('id', 'upload_file')
            ->get()
            ->map(function ($doc) use ($disk) {
                $doc->signed_url = $disk->exists($doc->upload_file)
                    ? $disk->temporaryUrl($doc->upload_file, now()->addMinutes(10))
                    : null;
                return $doc;
            });

        return view('tabs.student-show', compact('student', 'activities', 'courses', 'documents'));
    }

    // ------------------------
    // Update student info and courses
    // ------------------------
    public function updateStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->full_name = $request->full_name;
        $student->email = $request->email;
        $student->save();

        if ($request->courses) {
            $student->courses()->sync($request->courses);
        }

        return redirect()->route('tabs.student-show', $student->id)
            ->with('success', 'Student updated successfully!');
    }
}
