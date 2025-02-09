@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <h2>List Modules</h2>
    <!-- Button untuk menambah modul baru -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addModuleModal">Add New Module</button>

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
                        <a href="{{ route('admin.modules.edit', $module->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.modules.destroy', $module->id) }}" method="POST" style="display: inline-block;">
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

<!-- Modal Tambah Module -->
<div class="modal fade" id="addModuleModal" tabindex="-1" aria-labelledby="addModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addModuleForm" method="POST" action="{{ route('admin.modules.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addModuleModalLabel">Add New Module</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="course_id">Course</label>
                        <select name="course_id" id="course_id" class="form-control" required>
                            <option value="" selected disabled>Select Course</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="video_url">Video URL</label>
                        <input type="text" name="video_url" id="video_url" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Module</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        $('#modulesTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/Indonesian.json"
            }
        });

        $('#addModuleForm').on('submit', function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = form.serialize();

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                success: function (response) {
                    $('#modulesTable').DataTable().ajax.reload();
                    $('#addModuleModal').modal('hide');
                    form[0].reset();
                    alert('Module berhasil ditambahkan!');
                },
                error: function (xhr) {
                    alert('Gagal menambahkan module: ' + xhr.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection
