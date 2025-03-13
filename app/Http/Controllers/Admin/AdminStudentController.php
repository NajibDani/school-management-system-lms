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
    public function edit(Request $request, Student $student, string $id)
    {
        $student = Student::with(['user', 'currentClass'])->find($id);
        return response()->json($student);
    }

    // Update: Memperbarui data siswa
    public function update(Request $request, $id)
    {
        // Validasi data yang diterima
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'current_class_id' => 'required|integer',
        ]);

        // Temukan siswa berdasarkan ID
        $student = Student::findOrFail($id);

        // Update data pengguna
        $user = $student->user; // Asumsi relasi sudah didefinisikan
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        // Update data siswa
        $student->current_class_id = $request->current_class_id;
        $student->save();

        return response()->json(['message' => 'Data berhasil diperbarui!']);
    }

    // Delete: Menghapus data siswa
    public function destroy($id)
    {
        // Mencari student berdasarkan ID
        $student = Student::find($id);

        // Memeriksa apakah student ditemukan
        if ($student) {
            // Menghapus user jika user_id ada
            if ($student->user_id) {
                User::find($student->user_id)->delete();
            }

            // Menghapus student
            $student->delete();

            return response()->json(['success' => 'Data siswa dan pengguna dihapus dengan sukses.']);
        }

        return response()->json(['error' => 'Data siswa tidak ditemukan.'], 404);
    }
}