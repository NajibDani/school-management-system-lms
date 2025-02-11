@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <h2>List Courses</h2>
    <!-- Button untuk menambah modul baru -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addCourseModal">Add New Course</button>

    <table id="coursesTable" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Descriptions</th>
                <th>Teacher</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $key => $course)
                <tr>
                    <td>{{ $key += 1 }}</td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->description }}</td>
                    <td>{{ $course->teacher->name ?? 'Tidak Diketahui' }}</td>
                    <td>
                        {{-- <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-warning btn-sm btn-edit" data-id="{{ $course->id }}" data-toggle="modal" data-target="#editCourseModal">Edit</a> --}}
                        <a href="#" class="btn btn-warning btn-sm btn-edit" data-id="{{ $course->id }}"  data-toggle="modal" data-target="#editCourseModal">Edit</a>
                        {{-- <a href="#" class="btn btn-warning btn-sm btn-edit" data-id="{{ $course->id }}" data-toggle="modal" data-target="#editCourseModal">Edit</a> --}}


                        {{-- <button class="btn btn-warning btn-sm">Edit</button> --}}
                        <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" style="display: inline-block;">
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

<!-- Modal Tambah Course -->
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addCourseForm" method="POST" action="{{ route('admin.courses.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addCourseModalLabel">Add New Course</h5>
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
                        <label for="descriptions">Descripsi</label>
                        <input type="text" name="descriptions" id="descriptions" class="form-control">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Course</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Course -->
<div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editCourseForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="courseName" class="form-label">Course Name</label>
                        <input type="text" class="form-control" id="courseName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="courseDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="courseDescription" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="courseTeacher" class="form-label">Teacher</label>
                        <select class="form-control" id="courseTeacher" name="teacher_id">
                            <option value="" selected disabled>Select Teacher</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Your existing script -->
<script>
    $(document).on('click', '.btn-edit', function () {
        let course = $(this).data('course');

        $('#edit_course_id').val(course.id);
        $('#edit_name').val(course.name);
        $('#edit_descriptions').val(course.description);
        $('#edit_teacher').val(course.teacher_id);

        let formAction = "{{ route('admin.courses.update', ':id') }}";
        formAction = formAction.replace(':id', course.id);
        $('#editCourseForm').attr('action', formAction);

        $('#editCourseModal').modal('show');
    });
</script>

<script>
    $(document).ready(function () {
        $('#coursesTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/Indonesian.json"
            }
        });

        $('#addCourseForm').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                success: function (response) {
                    $('#coursesTable').DataTable().ajax.reload();
                    $('#addCourseModal').modal('hide');
                    form[0].reset();
                    alert('Course berhasil ditambahkan!');
                },
                error: function (xhr) {
                    alert('Gagal menambahkan module: ' + xhr.responseJSON.message);
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.btn-edit').on('click', function() {
            var courseId = $(this).data('id');
            var url = "{{ route('admin.courses.edit', ':id') }}";
            url = url.replace(':id', courseId);

            $.get(url, function(data) {
                $('#courseName').val(data.name);
                $('#courseDescription').val(data.description);
                $('#courseTeacher').val(data.teacher_id);

                var formAction = "{{ route('admin.courses.update', ':id') }}";
                formAction = formAction.replace(':id', courseId);
                $('#editCourseForm').attr('action', formAction);

                $('#editCourseModal').modal('show');
            });
        });
    });
</script>
@endsection
