@extends('admin.dashboard')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-4">
    <h2>List Student</h2>
    <!-- Button untuk menambah siswa baru -->
    <button id="addStudent" class="btn btn-primary mb-3">Tambah Student</button>

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
                        <button class="btn btn-warning btn-sm editStudent" data-id="{{ $student->id }}">Edit</button>
                        <button class="btn btn-danger btn-sm deleteStudent" data-id="{{ $student->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Student -->
<div class="modal fade" id="studentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Students Form</h5>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
            </div>
            <form id="studentForm">
                <div class="modal-body">
                    <input type="hidden" id="studentId">
                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" id="name" name="name" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="current_class_id">Assign Class</label>
                        <select name="current_class_id" id="current_class_id" class="form-control" required>
                            <option value="" selected disabled>No Class Assigned</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="role_id" value="3"> <!-- Role ID otomatis diset ke 3 -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    {{-- <button type="button" class="btn btn-success" onclick="saveStudent()">Save</button> --}}
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
        $("#addStudent").click(function () {
            resetForm();
            $("#studentModal .modal-title").text("Tambah Student");
            $("#studentModal").modal('show');
        });

        // Simpan atau Update Data
        $("#studentForm").submit(function (event) {
            event.preventDefault();
            let id = $("#studentId").val();
            let url = id ? `/admin/students/${id}` : '/admin/students';
            let type = id ? 'PUT' : 'POST';

            let data = {
                name: $("#name").val(),
                email: $("#email").val(),
                current_class_id: $("#current_class_id").val(),
                role_id: 3, // Role ID otomatis diset ke 3
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
                    $("#studentModal").modal('hide');
                    alert(response.message || "Data berhasil disimpan!");
                    location.reload();
                },
                error: function (xhr) {
                    alert("Terjadi kesalahan: " + xhr.responseText);
                }
            });
        });

        // Edit Data
        $(".editStudent").click(function () {
            let id = $(this).data("id");

            $.get(`/admin/students/${id}/edit`, function (data) {
                $("#studentId").val(data.id);

                if (data.user) {
                    $("#name").val(data.user.name);
                    $("#email").val(data.user.email);
                } else {
                    $("#name").val("");
                    $("#email").val("");
                }

                if (data.current_class) {
                    $("#current_class_id").val(data.current_class.id);
                } else {
                    $("#current_class_id").val("");
                }

                $("#studentModal .modal-title").text("Edit Student");
                $("#studentModal").modal('show');
            });
        });

        // Hapus Data
        $(".deleteStudent").click(function () {
            let id = $(this).data("id");

            if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                $.ajax({
                    url: `/admin/students/${id}`,
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
            $("#studentId").val('');
            $("#studentForm")[0].reset();
            $("#current_class_id").val("");
        }
    });
</script>
@endsection
