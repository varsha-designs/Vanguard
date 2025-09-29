<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Vanguard\Faculty;
use Vanguard\FacultyActivity;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;



class FacultyActivityController extends Controller
{
    public function index()
    {
        $activities = FacultyActivity::with('faculty')->latest()->get();
        return view('faculty_activities.index', compact('activities'));
    }

    // Show create form
    public function create()
    {
        $faculties = Faculty::all();
        return view('faculty_activities.create', compact('faculties'));
    }

    // Store new activity
    public function store(Request $request)
    {
       $data = $request->validate([
    'faculty_id'  => 'required|exists:faculties,id',
    'activities'  => 'required|array',
    'images.*'    => 'nullable|image|max:2048',
    'in_time'     => 'nullable|date_format:H:i',
    'out_time'    => 'nullable|date_format:H:i',
    'hours_spend' => 'nullable|numeric',
    'new_learning'=> 'nullable|string|max:1000',
    'todo_list'   => 'nullable|string|max:1000',
]);
         $hours_spend = null;
    if ($request->in_time && $request->out_time) {
         $in = Carbon::parse($request->in_time);
    $out = Carbon::parse($request->out_time);

        // Difference in hours (e.g., 7.50 for 7 hours 30 minutes)
       $hours_spend = round($out->diffInMinutes($in) / 60, 2);
    }

        // Handle image uploads
       $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $images[] = $img->store('faculty_activities', 'wasabi');
            }
        }

FacultyActivity::create([
    'faculty_id' => $request->faculty_id,
     'activities' => array_filter($request->activities),
            'images' => $images,
     'in_time'      => $request->in_time,
    'out_time'     => $request->out_time,
    'hours_spend'  => $hours_spend,
    'new_learning' => $request->new_learning,
    'todo_list'    => $request->todo_list,
]);


        return redirect()->route('faculty_activities.index')->with('success', 'Activity added successfully.');
    }
    public function show($id)
    {
           $activity = FacultyActivity::findOrFail($id);
/** @var FilesystemAdapter $disk */
$disk = Storage::disk('wasabi');

        $imagesWithTempUrl = [];
        if (!empty($activity->images)) {
            foreach ($activity->images as $img) {
                $imagesWithTempUrl[] = $disk
                    ->temporaryUrl($img, now()->addMinutes(10));
            }
        }

        return view('faculty_activities.show', [
            'activity' => $activity,
            'imagesWithTempUrl' => $imagesWithTempUrl
        ]);
    }


    // Show edit form
    public function edit($id)
    {
        $activity = FacultyActivity::findOrFail($id);
        $faculties = Faculty::all();
        return view('faculty_activities.edit', compact('activity', 'faculties'));
    }

    // Update activity
    public function update(Request $request, $id)
    {
        $activity = FacultyActivity::findOrFail($id);

        $data = $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'activities' => 'required|array',
            'images.*' => 'nullable|image|max:2048',
            'new_learning'=> 'nullable|string|max:1000',
    'todo_list'   => 'nullable|string|max:1000',
        ]);
         $hours_spend = null;
    if ($request->in_time && $request->out_time) {
        $in = Carbon::parse($request->in_time);
    $out =Carbon::parse($request->out_time);

        // Difference in hours (e.g., 7.50 for 7 hours 30 minutes)
       $hours_spend = round($out->diffInMinutes($in) / 60, 2);
    }

        // Handle new images
       // Handle removing old images
        $images = $activity->images ?? [];
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $index) {
                if (isset($images[$index])) {
                    Storage::disk('wasabi')->delete($images[$index]);
                    unset($images[$index]);
                }
            }
            $images = array_values($images); // reindex array
        }

        // Handle new uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $images[] = $img->store('faculty_activities', 'wasabi');
            }
        }
        $activity->update([
            'faculty_id' => $data['faculty_id'],
            'activities' => array_filter($data['activities']),
            'images' => $images,
              'in_time'      => $request->in_time,
           'out_time'     => $request->out_time,
           'hours_spend'   =>   $hours_spend,
            'new_learning' => $request->new_learning,
            'todo_list'    => $request->todo_list,
        ]);

        return redirect()->route('faculty_activities.index')->with('success', 'Activity updated successfully.');
    }

    // Delete activity
    public function destroy($id)
    {
        $activity = FacultyActivity::findOrFail($id);

        // Delete images from storage
        if (!empty($activity->images)) {
            foreach ($activity->images as $img) {
                Storage::disk('wasabi')->delete($img);
            }
        }

        $activity->delete();

        return redirect()->route('faculty_activities.index')->with('success', 'Activity deleted successfully.');
    }
}
