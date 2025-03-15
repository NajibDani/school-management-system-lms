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
        //
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
        $teacher = Teacher::with(['user'])->find($id);
        return response()->json($teacher);
    }

    // Update: Memperbarui data guru
    public function update(Request $request, $id)
    {
        // Validasi data yang diterima
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
        ]);

        // Temukan siswa berdasarkan ID
        $teacher = Teacher::findOrFail($id);

        // Update data pengguna
        $user = $teacher->user; // Asumsi relasi sudah didefinisikan
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // Update data siswa
        $teacher->subject = $request->subject;
        $teacher->save();

        return response()->json(['message' => 'Data berhasil diperbarui!']);
    }

    // Delete: Menghapus data guru
    public function destroy($id)
    {
        // Mencari teacher berdasarkan ID
        $teacher = Teacher::find($id);

        // Memeriksa apakah teacher ditemukan
        if ($teacher) {
            // Menghapus user jika user_id ada
            if ($teacher->user_id) {
                User::find($teacher->user_id)->delete();
            }

            // Menghapus teacher
            $teacher->delete();

            return response()->json(['success' => 'Data siswa dan pengguna dihapus dengan sukses.']);
        }

        return response()->json(['error' => 'Data siswa tidak ditemukan.'], 404);
    }
}