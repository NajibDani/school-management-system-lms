<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parents;
use App\Models\User;

class AdminParentController extends Controller
{
    // Read: Menampilkan semua data siswa
    public function index()
    {
        $parents = Parents::all(); // Mengambil semua data siswa
        return view('admin.parent.allParent', compact('parents'));
    }

    // Create: Menampilkan form untuk menambah siswa baru
    public function create()
    {
        return view('admin.parents.create');
    }

    // Create: Menyimpan data siswa baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        // Buat User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('password123'), // Password default
            'role_id' => 4, // Role parent
        ]);

        // Buat Parent
        Parents::create([
            'user_id' => $user->id,
        ]);

        return response()->json(['success' => true, 'message' => 'Parent berhasil ditambahkan.']);
    }

    // Update: Menampilkan form untuk memperbarui data siswa
    public function edit($id)
    {
        $parent = Parents::findOrFail($id); // Mengambil data siswa berdasarkan ID
        return view('admin.parents.edit', compact('parent'));
    }

    // Update: Memperbarui data siswa
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:parents,email,' . $id,
        ]);

        $parent = Parents::findOrFail($id);
        $parent->update($request->all());

        return redirect()->route('admin.parents.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    // Delete: Menghapus data siswa
    public function destroy($id)
    {
        $parent = Parents::findOrFail($id);
        $parent->delete();

        return redirect()->route('admin.parents.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
