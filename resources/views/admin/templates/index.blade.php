@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<main class="content">
    <div class="container-fluid p-0">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


        <h1 class="h3 mb-3">Templates</h1>

        <!-- Tombol Trigger Modal -->
        <button class="btn btn-primary mb-3" onclick="openAddTemplateModal()">
            + Tambah Template
        </button>

        <div class="row">
            <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">

                        <h5 class="card-title mb-0">List Contact</h5>
                    </div>
                    <div class="table-responsive">
                        <table id="templates-table" class="table table-hover my-0 table-responsive">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class="d-none d-xl-table-cell">Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<!-- Modal Tambah/Edit Template -->
<div class="modal fade" id="templateModal" tabindex="-1" aria-labelledby="templateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="templateForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="templateModalLabel">Tambah Template</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="templateName" class="form-label">Nama</label>
                        <input type="text" name="name" id="templateName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea name="content" id="templateContent" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitTemplateBtn">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script>
    
    // Auto-close alert setelah 5 detik
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            // Hapus class 'show' untuk memicu animasi fade
            alert.classList.remove('show');
            alert.classList.add('fade');

            // Tunggu animasi selesai, lalu remove dari DOM
            setTimeout(() => alert.remove(), 300);
        }
    }, 5000); // 5000ms = 5 detik


    function openAddTemplateModal() {
        // Set action & method for ADD
        $('#templateForm').attr('action', '{{ route('templates.store') }}');
        $('#formMethod').val('POST');
        $('#templateModalLabel').text('Tambah Template');
        $('#submitTemplateBtn').text('Simpan');

        // Kosongkan field
        $('#templateName').val('');
        $('#templateContent').val('');

        // Tampilkan modal
        $('#templateModal').modal('show');
    }

    function openEditTemplateModal(id) {
        // Set action & method for EDIT

        let name    = document.getElementById('name_' + id).value;
        let content = document.getElementById('content_' + id).value;
        let url = '{{ route("templates.update", ":id") }}'.replace(':id', id);
        $('#templateForm').attr('action', url);
        $('#formMethod').val('PUT');
        $('#templateModalLabel').text('Edit Template');
        $('#submitTemplateBtn').text('Update');

        // Isi field
        $('#templateName').val(name);
        $('#templateContent').val(content);

        // Tampilkan modal
        $('#templateModal').modal('show');
    }

    document.addEventListener('DOMContentLoaded', function () {
        $('#templates-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("templates.datatable") }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });

</script>
@endsection