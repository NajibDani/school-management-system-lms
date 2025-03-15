<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Teacher;

class AdminCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with('teacher')->get();
        $teachers = Teacher::all();

        return view('admin.courses.allCourse', compact('courses', 'teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'teacher_id' => 'required|exists:users,id', // Pastikan teacher_id ada di tabel users
        ]);

        Course::create($request->all());
        return response()->json(['success' => 'Course added successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    public function edit(Request $request, string $id)
    {
        $course = Course::with('teacher')->find($id); // Mengambil data kelas beserta guru
        if (!$course) {
            return response()->json(['message' => 'Class not found'], 404);
        }
        return response()->json($course);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, string $id)
    {
        $course = Course::find($id);
        $course->update($request->all());
        return response()->json(['success' => 'Courses updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Course::find($id)->delete();
        return response()->json(['success' => 'Courses deleted successfully.']);
    }
}