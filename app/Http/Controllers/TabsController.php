<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Vanguard\Faculty;
use Vanguard\Student;
use Vanguard\DailyActivity;
use Vanguard\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TabsController extends Controller
{
   public function profile()
    {
        $students = Student::all();
        return view('tabs.profile', compact('students'));
    }

    public function courseEnrollment()
    {
            $courses = Course::withCount('students')->get(); // assuming Student hasMany Courses
        return view('tabs.course-enrollment', compact('courses'));
    }

    public function activities()
    {
        $activities = DailyActivity::with('student')->get();
        return view('tabs.activities', compact('activities'));
    }

    public function photos()
    {
         $students = DB::table('students')->get();

    $disk = Storage::disk('wasabi');

    foreach ($students as $student) {

        // Join using the correct column `activity_id`
        $photos = DB::table('daily_activities')
            ->join('activity_images', 'daily_activities.id', '=', 'activity_images.activity_id')
            ->where('daily_activities.student_id', $student->id)
            ->select('activity_images.image_path')
            ->get();

            /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
             foreach ($photos as $photo) {
            if ($disk->exists($photo->image_path)) {
                $photo->signed_url = $disk->temporaryUrl(
                    $photo->image_path,
                    now()->addMinutes(1)
                );
            } else {
                $photo->signed_url = null;
            }
            }

            $student->photos = $photos;
        }
        return view('tabs.photos', compact('students'));
    }

}
