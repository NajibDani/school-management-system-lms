@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <h2>List Student</h2>
    <!-- Button untuk menambah siswa baru -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addStudentModal">Add New Student</button>

    <table id="studentsTable" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Kelas</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $key => $student)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $student->user->name }}</td> <!-- Nama user -->
                    <td>{{ $student->user->email }}</td> <!-- Email user -->
                    <td>{{ $student->currentClass->name ?? '-' }}</td> <!-- Nama kelas -->
                    <td>
                        <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Student -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addStudentForm" method="POST" action="{{ route('admin.students.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="current_class_id">Assign Class</label>
                        <select name="current_class_id" id="current_class_id" class="form-control">
                            <option value="" selected>No Class Assigned</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="role_id" value="3"> <!-- Role ID otomatis diset ke 3 -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Student</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Tambahkan DataTables Library -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        // Inisialisasi DataTables
        $('#studentsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/Indonesian.json"
            }
        });

        // AJAX Form Submit untuk menambah student
        $('#addStudentForm').on('submit', function (e) {
            e.preventDefault(); // Prevent default submit
            let form = $(this);
            let formData = form.serialize();

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                success: function (response) {
                    // Refresh tabel setelah berhasil
                    $('#studentsTable').DataTable().ajax.reload();
                    $('#addStudentModal').modal('hide'); // Tutup modal
                    form[0].reset(); // Reset form
                    alert('Student berhasil ditambahkan!');
                },
                error: function (xhr) {
                    // Tampilkan error jika ada
                    alert('Gagal menambahkan student: ' + xhr.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection