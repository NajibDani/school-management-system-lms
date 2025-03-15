@extends('admin.dashboard')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-4">
    <h2>List Teacher</h2>
    <!-- Button untuk menambah guru baru -->
    <button id="addTeacher" class="btn btn-primary mb-3">Add New Teacher</button>
    {{-- <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addTeacherModal">Add New Teacher</button> --}}

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
                    <button class="btn btn-warning btn-sm editTeacher" data-id="{{ $teacher->id }}">Edit</button>
                    <button class="btn btn-danger btn-sm deleteTeacher" data-id="{{ $teacher->id }}">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Teacher -->
<div class="modal fade" id="teacherModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Teacher Form</h5>
                <button type="button" class="btn-close" data-dismiss="modal">&times;</button>
            </div>
            <form id="teacherForm">
                <div class="modal-body">
                    <input type="hidden" id="teacherId">
                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="subject">Subject</label>
                        <input type="text" name="subject" id="subject" class="form-control" required>
                    </div>
                    <input type="hidden" name="role_id" value="3"> <!-- Role ID otomatis diset ke 3 -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    {{-- <button type="button" class="btn btn-success" onclick="saveteacher()">Save</button> --}}
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
        $("#addTeacher").click(function () {
            resetForm();
            $("#teacherModal .modal-title").text("Tambah Teacher");
            $("#teacherModal").modal('show');
        });

        // Simpan atau Update Data
        $("#teacherForm").submit(function (event) {
            event.preventDefault();
            let id = $("#teacherId").val();
            let url = id ? `/admin/teachers/${id}` : '/admin/teachers';
            let type = id ? 'PUT' : 'POST';

            let data = {
                name: $("#name").val(),
                email: $("#email").val(),
                subject: $("#subject").val(),
                role_id: 2, // Role ID otomatis diset ke 2
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
                    $("#teacherModal").modal('hide');
                    alert(response.message || "Data berhasil disimpan!");
                    location.reload();
                },
                error: function (xhr) {
                    alert("Terjadi kesalahan: " + xhr.responseText);
                }
            });
        });

        // Edit Data
        $(".editTeacher").click(function () {
            let id = $(this).data("id");

            $.get(`/admin/teachers/${id}/edit`, function (data) {
                $("#teacherId").val(data.id);
                $("#subject").val(data.subject);

                if (data.user) {
                    $("#name").val(data.user.name);
                    $("#email").val(data.user.email);
                } else {
                    $("#name").val("");
                    $("#email").val("");
                }

                $("#teacherModal .modal-title").text("Edit Teacher");
                $("#teacherModal").modal('show');
            });
        });

        // Hapus Data
        $(".deleteTeacher").click(function () {
            let id = $(this).data("id");

            if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                $.ajax({
                    url: `/admin/teachers/${id}`,
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
            $("#teacherId").val('');
            $("#teacherForm")[0].reset();
            $("#current_class_id").val("");
        }
    });


    // $(document).ready(function() {
    //     // Inisialisasi DataTables
    //     $('#teachersTable').DataTable({
    //         "language": {
    //             "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/Indonesian.json"
    //         }
    //     });

    //     // AJAX Form Submit untuk menambah teacher
    //     $('#addTeacherForm').on('submit', function(e) {
    //         e.preventDefault(); // Prevent default submit
    //         let form = $(this);
    //         let formData = form.serialize();

    //         $.ajax({
    //             url: form.attr('action'),
    //             method: form.attr('method'),
    //             data: formData,
    //             success: function(response) {
    //                 // Refresh tabel setelah berhasil
    //                 $('#teachersTable').DataTable().ajax.reload();
    //                 $('#addTeacherModal').modal('hide'); // Tutup modal
    //                 form[0].reset(); // Reset form
    //                 alert('Teacher berhasil ditambahkan!');
    //             },
    //             error: function(xhr) {
    //                 // Tampilkan error jika ada
    //                 alert('Gagal menambahkan teacher: ' + xhr.responseJSON.message);
    //             }
    //         });
    //     });
    // });
</script>
@endsection
