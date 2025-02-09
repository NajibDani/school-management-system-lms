<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\Classes;
use App\Models\ClassHistory;

class AdminStudentController extends Controller
{
    // Read: Menampilkan semua data siswa
    public function index()
    {
        $students = Student::with(['user', 'currentClass'])->get(); // Mengambil data siswa dengan user dan kelas saat ini
        $classes = Classes::with('teacher')->get(); // Mengambil data kelas dengan guru
        return view('admin.student.allStudent', compact('students', 'classes'));
    }

    // Create: Menampilkan form untuk menambah siswa baru
    public function create()
    {
        return view('admin.students.create');
    }

    // Create: Menyimpan data siswa baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'current_class_id' => 'nullable|exists:tbl_classes,id', // Validasi kelas
        ]);
    
        // Buat User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password123'),
            'role_id' => 3,
        ]);
    
        // Buat Student
        $student = Student::create([
            'user_id' => $user->id,
            'enrollment_number' => 'STU' . time(),
        ]);
    
        // Jika kelas dipilih, tambahkan ke ClassHistory
        if ($request->current_class_id) {
            ClassHistory::create([
                'student_id' => $student->id,
                'class_id' => $request->current_class_id,
                'start_date' => now(),
            ]);
    
            // Update current_class_id di tabel Student
            $student->update(['current_class_id' => $request->current_class_id]);
        }
    
        return response()->json(['success' => true, 'message' => 'Student berhasil ditambahkan.']);
    }

    // Update: Menampilkan form untuk memperbarui data siswa
    public function edit($id)
    {
        $student = Student::with(['user', 'currentClass'])->findOrFail($id); // Ambil data siswa
        $classes = Classes::all(); // Ambil semua kelas untuk dropdown
        return view('admin.students.edit', compact('student', 'classes'));
    }


    // Update: Memperbarui data siswa
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'current_class_id' => 'nullable|exists:classes,id', // Validasi kelas
        ]);

        $student = Student::findOrFail($id);
        $student->update([
            'current_class_id' => $request->current_class_id, // Update kelas
        ]);

        $student->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }


    // Delete: Menghapus data siswa
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
