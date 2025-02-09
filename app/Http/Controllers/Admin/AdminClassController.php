<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Classes;
use App\Models\User;

class AdminClassController extends Controller
{
    /**
     * Menampilkan semua data kelas.
     */
    public function index()
    {
        $classes = Classes::with('teacher')->get(); // Mengambil semua kelas beserta data guru
        $teachers = User::where('role_id', 2)->get(); // Mengambil semua user dengan role guru
        return view('admin.allClasses', compact('classes', 'teachers'));
    }

    /**
     * Menampilkan form untuk membuat kelas baru.
     */
    public function create()
    {
        $teachers = User::where('role_id', 2)->get(); // Mengambil semua guru
        return view('admin.classes.create', compact('teachers'));
    }

    /**
     * Menyimpan data kelas baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        Classes::create($request->only('name', 'teacher_id'));

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data kelas.
     */
    public function edit($id)
    {
        $class = Classes::findOrFail($id); // Mengambil data kelas berdasarkan ID
        $teachers = User::where('role_id', 2)->get(); // Mengambil semua guru
        return view('admin.classes.edit', compact('class', 'teachers'));
    }

    /**
     * Memperbarui data kelas di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        $class = Classes::findOrFail($id);
        $class->update($request->only('name', 'teacher_id'));

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Menghapus data kelas dari database.
     */
    public function destroy($id)
    {
        $class = Classes::findOrFail($id);
        $class->delete();

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
