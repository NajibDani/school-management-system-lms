@extends('admin.dashboard')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-4">
    <h2>List Class</h2>
    <!-- Button untuk menambah kelas baru -->
    <button id="addClass" class="btn btn-primary mb-3">Add New Class</button>

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
                    <button class="btn btn-warning btn-sm editClass" data-id="{{ $class->id }}">Edit</button>
                    <button class="btn btn-danger btn-sm deleteClass" data-id="{{ $class->id }}">Delete</button>
                    {{-- <a href="{{ route('admin.classes.edit', $class->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this class?')">Delete</button>
                    </form> --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Class -->
<div class="modal fade" id="classModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Class Form</h5>
                <button type="button" class="btn-close" data-dismiss="modal">&times;</button>
            </div>
            <form id="classForm">
                <div class="modal-body">
                    <input type="hidden" id="classId">
                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" id="name" name="name" class="form-control">
                    </div>
                    {{-- <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div> --}}
                    <div class="form-group">
                        <label for="teacher_id">Assign Teacher</label>
                        <select name="teacher_id" id="teacher_id" class="form-control" required>
                            <option value="" selected>No Teacher Assigned</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    {{-- <button type="button" class="btn btn-success" onclick="saveclass()">Save</button> --}}
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Tambahkan DataTables Library -->
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> --}}

<script>
    $(document).ready(function () {
        // Tombol Create: Kosongkan Form dan Tampilkan Modal
        $("#addClass").click(function () {
            resetForm();
            $("#classModal .modal-title").text("Tambah Class");
            $("#classModal").modal('show');
        });

        // Simpan atau Update Data
        $("#classForm").submit(function (event) {
            event.preventDefault();
            let id = $("#classId").val();
            let url = id ? `/admin/classes/${id}` : '/admin/classes';
            let type = id ? 'PUT' : 'POST';

            let data = {
                name: $("#name").val(),
                teacher_id: $("#teacher_id").val(),
            };

            $.ajax({
                url: url,
                type: type,
                data: JSON.stringify(data),
                contentType: 'application/json',
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $("#classModal").modal('hide');
                    alert(response.message || "Data berhasil disimpan!");
                    location.reload();
                },
                error: function (xhr) {
                    alert("Terjadi kesalahan: " + xhr.responseText);
                }
            });
        });

        // Edit Data
        $(".editClass").click(function () {
            let id = $(this).data("id");

            $.get(`/admin/classes/${id}/edit`, function (data) {
                $("#classId").val(data.id);
                $("#name").val(data.name);

                if (data.teacher) {
                    $("#teacher_id").val(data.teacher.id);
                } else {
                    $("#teacher_id").val("");
                }

                $("#classModal .modal-title").text("Edit Class");
                $("#classModal").modal('show');
            });
        });

        // Hapus Data
        $(".deleteClass").click(function () {
            let id = $(this).data("id");

            if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                $.ajax({
                    url: `/admin/classes/${id}`,
                    type: 'DELETE',
                    data: JSON.stringify({ _token: $('meta[name="csrf-token"]').attr('content') }),
                    contentType: 'application/json',
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        alert(response.message || "Data berhasil dihapus!");
                        location.reload();
                    },
                    error: function (xhr) {
                        alert("Terjadi kesalahan: " + xhr.responseText);
                    }
                });
            }
        });

        // Fungsi Reset Form
        function resetForm() {
            $("#classId").val('');
            $("#classForm")[0].reset();
            $("#teacher_id").val("");
        }
    });
</script>
@endsection
