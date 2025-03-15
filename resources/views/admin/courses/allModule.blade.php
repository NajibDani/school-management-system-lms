@extends('admin.dashboard')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-4">
    <h2>List Modules</h2>
    <!-- Button untuk menambah modul baru -->
    <button id="addModule" class="btn btn-primary mb-3">Add New Module</button>

    <table id="modulesTable" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Course</th>
                <th>Video</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($modules as $key => $module)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $module->title }}</td>
                    <td>{{ $module->course->name }}</td>
                    <td>
                        @if ($module->video_url)
                            <a href="{{ $module->video_url }}" target="_blank">Watch Video</a>
                        @else
                            No Video
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm editModule" data-id="{{ $module->id }}">Edit</button>
                        <button class="btn btn-danger btn-sm deleteModule" data-id="{{ $module->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Module -->
<div class="modal fade" id="moduleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Module Form</h5>
                <button type="button" class="btn-close" data-dismiss="modal">&times;</button>
            </div>
            <form id="moduleForm">
                <div class="modal-body">
                    <input type="hidden" id="moduleId">
                    <div class="form-group mb-3">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="content">Content</label>
                        <input type="text" id="content" name="content" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="course_id">Assign Teacher</label>
                        <select name="course_id" id="course_id" class="form-control" required>
                            <option value="" selected disabled>Select Course</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="video_url">Video URL</label>
                        <input type="url" name="video_url" id="video_url" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
        // Tombol Create: Kosongkan Form dan Tampilkan Modal
        $("#addModule").click(function () {
            resetForm();
            $("#moduleModal .modal-title").text("Tambah Modul");
            $("#moduleModal").modal('show');
        });

        // Simpan atau Update Data
        $("#moduleForm").submit(function (event) {
            event.preventDefault();
            let id = $("#moduleId").val();
            let url = id ? `/admin/modules/${id}` : '/admin/modules';
            let type = id ? 'PUT' : 'POST';

            let data = {
                title: $("#title").val(),
                content: $("#content").val(),
                course_id: $("#course_id").val(),
                video_url: $("#video_url").val(),
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
                    $("#moduleModal").modal('hide');
                    alert(response.message || "Data berhasil disimpan!");
                    location.reload();
                },
                error: function (xhr) {
                    alert("Terjadi kesalahan: " + xhr.responseText);
                }
            });
        });

        // Edit Data
        $(".editModule").click(function () {
            let id = $(this).data("id");

            $.get(`/admin/modules/${id}/edit`, function (data) {
                $("#moduleId").val(data.id);
                $("#title").val(data.title);
                $("#content").val(data.content);
                $("#video_url").val(data.video_url);

                if (data.course) {
                    $("#course_id").val(data.course.id);
                } else {
                    $("#course_id").val("");
                }

                $("#moduleModal .modal-title").text("Edit Module");
                $("#moduleModal").modal('show');
            });
        });

        // Hapus Data
        $(".deleteModule").click(function () {
            let id = $(this).data("id");

            if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                $.ajax({
                    url: `/admin/modules/${id}`,
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
            $("#moduleId").val('');
            $("#moduleForm")[0].reset();
            $("#teacher_id").val("");
        }
    });


    // $(document).ready(function () {
    //     $('#modulesTable').DataTable({
    //         "language": {
    //             "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/Indonesian.json"
    //         }
    //     });

    //     $('#addModuleForm').on('submit', function (e) {
    //         e.preventDefault();
    //         let form = $(this);
    //         let formData = form.serialize();

    //         $.ajax({
    //             url: form.attr('action'),
    //             method: form.attr('method'),
    //             data: formData,
    //             success: function (response) {
    //                 $('#modulesTable').DataTable().ajax.reload();
    //                 $('#addModuleModal').modal('hide');
    //                 form[0].reset();
    //                 alert('Module berhasil ditambahkan!');
    //             },
    //             error: function (xhr) {
    //                 alert('Gagal menambahkan module: ' + xhr.responseJSON.message);
    //             }
    //         });
    //     });
    // });
</script>
@endsection
