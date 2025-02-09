@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <h2>List Teacher</h2>
    <!-- Button untuk menambah guru baru -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addTeacherModal">Add New Teacher</button>

    <table id="teachersTable" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($teachers as $key => $teacher)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $teacher->user->name }}</td> <!-- Nama user -->
                <td>{{ $teacher->user->email }}</td> <!-- Email user -->
                <td>{{ $teacher->subject ?? '-' }}</td> <!-- Subject taught -->
                <td>
                    <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Teacher -->
<div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addTeacherForm" method="POST" action="{{ route('admin.teachers.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addTeacherModalLabel">Add New Teacher</h5>
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
                        <label for="subject">Subject</label>
                        <input type="text" name="subject" id="subject" class="form-control" required>
                    </div>
                    <input type="hidden" name="role_id" value="2"> <!-- Role ID otomatis diset ke 2 untuk guru -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Teacher</button>
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
    $(document).ready(function() {
        // Inisialisasi DataTables
        $('#teachersTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/Indonesian.json"
            }
        });

        // AJAX Form Submit untuk menambah teacher
        $('#addTeacherForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default submit
            let form = $(this);
            let formData = form.serialize();

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                success: function(response) {
                    // Refresh tabel setelah berhasil
                    $('#teachersTable').DataTable().ajax.reload();
                    $('#addTeacherModal').modal('hide'); // Tutup modal
                    form[0].reset(); // Reset form
                    alert('Teacher berhasil ditambahkan!');
                },
                error: function(xhr) {
                    // Tampilkan error jika ada
                    alert('Gagal menambahkan teacher: ' + xhr.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection