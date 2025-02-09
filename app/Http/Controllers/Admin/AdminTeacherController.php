<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;

class AdminTeacherController extends Controller
{
    // Read: Menampilkan semua data guru
    public function index()
    {
        $teachers = Teacher::all(); // Mengambil semua data guru
        return view('admin.teacher.allTeacher', compact('teachers'));
    }

    // Create: Menampilkan form untuk menambah guru baru
    public function create()
    {
        return view('admin.teacher.create');
    }

    // Create: Menyimpan data guru baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'subject' => 'required|string|max:255',
        ]);

        // Buat User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('guru123'), // Password default
            'role_id' => 2, // Role teacher
        ]);

        // Buat Teacher
        Teacher::create([
            'user_id' => $user->id,
            'subject' => $request->subject,
            'enrollment_number' => 'TCU' . time(), // Atur enrollment number unik
        ]);

        return response()->json(['success' => true, 'message' => 'Teacher berhasil ditambahkan.']);
    }

    // Update: Menampilkan form untuk memperbarui data guru
    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id); // Mengambil data guru berdasarkan ID
        return view('admin.teacher.edit', compact('teacher'));
    }

    // Update: Memperbarui data guru
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'subject' => 'required|string|max:255',
        ]);

        $teacher = Teacher::findOrFail($id);
        $teacher->update($request->all());

        return redirect()->route('admin.teacher.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    // Delete: Menghapus data guru
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return redirect()->route('admin.teacher.index')->with('success', 'Data guru berhasil dihapus.');
    }
}
