<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Menampilkan informasi profil siswa (Read)
    public function profile()
    {
        $student = Auth::user(); // Mengambil data siswa yang sedang login
        return view('student.profile', compact('student'));
    }

    // Menampilkan form untuk mengedit data pribadi siswa
    public function editProfile()
    {
        $student = Auth::user(); // Mengambil data siswa yang sedang login
        return view('student.edit-profile', compact('student'));
    }

    // Memperbarui data pribadi siswa (Update)
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . Auth::id(),
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $student = Auth::user(); // Mengambil data siswa yang sedang login
        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $student->password,
        ]);

        return redirect()->route('student.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    // Menampilkan modul atau kelas yang terkait dengan siswa
    public function myModules()
    {
        $student = Auth::user();
        $modules = $student->modules; // Ambil modul yang terkait dengan siswa (relasi harus diatur di model)
        return view('student.modules', compact('modules'));
    }

    // Menampilkan nilai siswa
    public function myGrades()
    {
        $student = Auth::user();
        $grades = $student->grades; // Ambil nilai yang terkait dengan siswa (relasi harus diatur di model)
        return view('student.grades', compact('grades'));
    }
}
