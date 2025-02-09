@extends('admin.dashboard')

@section('content')
<div class="container mt-4">
    <h2>List Parents</h2>
    <!-- Button untuk menambah parent baru -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addParentModal">Add New Parent</button>

    <table id="parentsTable" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($parents as $key => $parent)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $parent->user->name }}</td> <!-- Nama user -->
                <td>{{ $parent->user->email }}</td> <!-- Email user -->
                <td>
                    <a href="{{ route('admin.parents.edit', $parent->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.parents.destroy', $parent->id) }}" method="POST" style="display: inline-block;">
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

<!-- Modal Tambah Parent -->
<div class="modal fade" id="addParentModal" tabindex="-1" aria-labelledby="addParentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addParentForm" method="POST" action="{{ route('admin.parents.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addParentModalLabel">Add New Parent</h5>
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
                    <input type="hidden" name="role_id" value="4"> <!-- Role ID otomatis diset ke 4 untuk Parent -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Parent</button>
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
        $('#parentsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/Indonesian.json"
            }
        });

        // AJAX Form Submit untuk menambah parent
        $('#addParentForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default submit
            let form = $(this);
            let formData = form.serialize();

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                success: function(response) {
                    // Refresh tabel setelah berhasil
                    $('#parentsTable').DataTable().ajax.reload();
                    $('#addParentModal').modal('hide'); // Tutup modal
                    form[0].reset(); // Reset form
                    alert('Parent berhasil ditambahkan!');
                },
                error: function(xhr) {
                    // Tampilkan error jika ada
                    alert('Gagal menambahkan parent: ' + xhr.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection
