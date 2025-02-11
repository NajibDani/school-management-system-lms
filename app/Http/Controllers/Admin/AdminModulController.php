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
        $courses = Course::all(); // Ambil semua kursus
        return view('admin.modules.create', compact('courses'));
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

        try {
            Module::create($request->all());
            return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Menampilkan form edit modul
    public function edit($id)
    {
        $module = Module::findOrFail($id);
        $courses = Course::all();
        return view('admin.modules.edit', compact('module', 'courses'));
    }

    // Memperbarui modul
    public function update(Request $request, $id)
    {
        $request->validate([
            'course_id' => 'required|exists:tbl_courses,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
        ]);

        try {
            $module = Module::findOrFail($id);
            $module->update($request->all());

            return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Menghapus modul
    public function destroy($id)
    {
        try {
            $module = Module::findOrFail($id);
            $module->delete();

            return redirect()->route('admin.modules.index')->with('success', 'Modul berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}