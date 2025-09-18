<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Vanguard\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:50|unique:courses',
            'level'       => 'required|in:beginner,intermediate,advanced',
            'section'     => 'required|string',
            'concepts'    => 'required|string',
            'project'     => 'required|string',
            'course_fee' => 'required|numeric|min:4',
        ]);

       Course::create([
    'course_name' => $request->course_name,
    'course_code' => $request->course_code,
    'level'       => $request->level,
    'section'     => $request->section,
    'concepts'    => $request->concepts,
    'project'     => $request->project,
    'course_fee'  => $request->course_fee,
]);

        return redirect()->route('courses.index')
                         ->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:50|unique:courses,course_code,'.$course->id,
            'level'       => 'required|in:beginner,intermediate,advanced',
            'section'     => 'nullable|string',
            'concepts'    => 'nullable|string',
            'project'     => 'nullable|string',
            'course_fee' => 'required|numeric|min:5',
        ]);

      $course->update([
    'course_name' => $request->course_name,
    'course_code' => $request->course_code,
    'level'       => $request->level,
    'section'     => $request->section,
    'concepts'    => $request->concepts,
    'project'     => $request->project,
    'course_fee'  => $request->course_fee,
]);

        return redirect()->route('courses.index')
                         ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')
                         ->with('success', 'Course deleted successfully.');
    }
}
