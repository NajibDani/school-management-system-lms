<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Course;

class AdminModulController extends Controller
{
    // Menampilkan semua modul
    public function index()
    {
        $modules = Module::with('course')->get(); // Ambil semua modul beserta kursus terkait
        $courses = Course::all(); // Ambil semua kursus
        return view('admin.courses.allModule', compact('modules', 'courses'));
    }

    // Menampilkan form tambah modul
    public function create()
    {
        //
    }

    // Menyimpan modul baru
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:tbl_courses,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
        ]);

        Module::create($request->all());
        return response()->json(['success' => 'Module added successfully.']);
    }

    // Menampilkan form edit modul
    public function edit($id)
    {
        $module = Module::with('course')->find($id); // Mengambil data kelas beserta guru
        if (!$module) {
            return response()->json(['message' => 'Class not found'], 404);
        }
        return response()->json($module);
    }

    // Memperbarui modul
    public function update(Request $request, $id)
    {
        $module = Module::find($id);
        $module->update($request->all());
        return response()->json(['success' => 'Module updated successfully.']);
    }

    // Menghapus modul
    public function destroy($id)
    {
        Module::find($id)->delete();
        return response()->json(['success' => 'Courses deleted successfully.']);
    }
}
