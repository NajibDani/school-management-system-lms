@extends('admin.dashboard')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-4">
    <h2>List Courses</h2>
    <button id="addCourse" class="btn btn-primary mb-3">Tambah Courses</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Deskripsi</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="courseTable">
            @foreach($courses as $key => $course)
                <tr id="row_{{ $course->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->description }}</td>
                    <td>{{ $course->teacher->name }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm editCourse" data-id="{{ $course->id }}">Edit</button>
                        <button class="btn btn-danger btn-sm deleteCourse" data-id="{{ $course->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="courseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Courses Form</h5>
                <button type="button" class="btn-close" data-dismiss="modal"></button>
            </div>
            <form id="courseForm">
                <div class="modal-body">
                    <input type="hidden" id="courseId">
                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" id="name" name="name" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label>Deskripsi</label>
                        <input type="text" id="descriptions" name="descriptions" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="teacher">Teacher</label>
                        <select name="teacher" id="teacher" class="form-control" required>
                            <option value="" selected disabled>Select Teacher</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
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

{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> --}}

<script>
    $(document).ready(function () {
        // $('#coursesTable').DataTable({
        //     "language": {
        //         "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/Indonesian.json"
        //     }
        // });

        // Tombol Create: Kosongkan Form dan Tampilkan Modal
        $("#addCourse").click(function () {
            $("#courseId").val('');
            $("#courseForm")[0].reset();
            $("#courseModalLabel").text("Tambah Course");
            $("#courseModal").modal('show');
        });

        // Simpan atau Update Data
        $("#saveCourse").click(function () {
            let id = $("#courseId").val();
            let data = {
                name: $("#name").val(),
                description: $("#descriptions").val(),
                teacher: $("#teacher").val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };
            let url = id ? `/admin/courses/${id}` : '/admin/courses';
            let type = id ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: type,
                data: data,
                success: function () {
                    $("#courseModal").modal('hide'); // Sembunyikan modal
                    location.reload(); // Refresh halaman
                }
            });
        });

        // Edit Data
        $(".editCourse").click(function () {
            let id = $(this).data("id");

            $.get(`/admin/courses/${id}/edit`, function (data) {
                $("#courseId").val(data.id);
                $("#name").val(data.name);
                $("#descriptions").val(data.description);

                // Cek apakah data guru ada
                if (data.teacher) {
                    $("#teacher").val(data.teacher.id);
                } else {
                    $("#teacher").val(""); // Reset nilai jika tidak ada guru
                    $("#teacher").append('<option value="" disabled selected>Tidak tersedia</option>');
                }

                $("#courseModal").modal('show');
            });
        });

        // Hapus Data
        $(".deleteCourse").click(function () {
            let id = $(this).data("id");

            if (confirm("Are you sure?")) {
                $.ajax({
                    url: `/admin/courses/${id}`,
                    type: 'DELETE',
                    data: { _token: $('meta[name="csrf-token"]').attr('content') },
                    success: function () {
                        location.reload();
                    }
                });
            }
        });

        // Clear Form
        $("#addCourse").click(function () {
            $("#courseId").val('');
            $("#courseForm")[0].reset();
            $("#courseModal").modal('show');
        });
    });
</script>

@endsection
