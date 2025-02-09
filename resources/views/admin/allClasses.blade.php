@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <h2>List Class</h2>
    <!-- Button untuk menambah kelas baru -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addClassModal">Add New Class</button>

    <table id="classesTable" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Class Name</th>
                <th>Teacher</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($classes as $key => $class)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $class->name }}</td>
                <td>{{ $class->teacher->name ?? 'No Teacher Assigned' }}</td> <!-- Guru (jika ada) -->
                <td>
                    <a href="{{ route('admin.classes.edit', $class->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this class?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Class -->
<div class="modal fade" id="addClassModal" tabindex="-1" aria-labelledby="addClassModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addClassForm" method="POST" action="{{ route('admin.classes.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addClassModalLabel">Add New Class</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Class Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="teacher_id">Assign Teacher</label>
                        <select name="teacher_id" id="teacher_id" class="form-control">
                            <option value="" selected>No Teacher Assigned</option>
                            @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Class</button>
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
        $('#classesTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/Indonesian.json"
            }
        });

        // AJAX Form Submit untuk menambah class
        $('#addClassForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default submit
            let form = $(this);
            let formData = form.serialize();

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                success: function(response) {
                    // Refresh tabel setelah berhasil
                    $('#classesTable').DataTable().ajax.reload();
                    $('#addClassModal').modal('hide'); // Tutup modal
                    form[0].reset(); // Reset form
                    alert('Class berhasil ditambahkan!');
                },
                error: function(xhr) {
                    // Tampilkan error jika ada
                    alert('Gagal menambahkan class: ' + xhr.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection
