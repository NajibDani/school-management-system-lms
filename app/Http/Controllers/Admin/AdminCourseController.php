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
        Course::create($request->all());
        return response()->json(['success' => 'Courses added successfully.']);

        // // Validasi data input
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'descriptions' => 'nullable|string',
        //     'teacher' => 'required|exists:users,id',
        // ]);

        // try {
        //     // Simpan data ke database
        //     Course::create([
        //         'name' => $request->name,
        //         'description' => $request->descriptions,
        //         'teacher_id' => $request->teacher,
        //     ]);

        //     return redirect()->route('admin.courses.index')->with('success', 'Course berhasil ditambahkan.');
        // } catch (\Exception $e) {
        //     return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        // }
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
    public function edit(Request $request, Course $course, string $id)
    {
        $course = Course::find($id);
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
        // try {
        //     $course = Course::findOrFail($id);
        //     $course->delete();

        //     return redirect()->route('admin.courses.allCourse')->with('success', 'Modul berhasil dihapus.');
        // } catch (\Exception $e) {
        //     return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        // }
    }
}
