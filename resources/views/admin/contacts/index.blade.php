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


        <h1 class="h3 mb-3">Contacts</h1>

        <!-- Tombol Trigger Modal -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addContactModal">
            + Tambah Kontak
        </button>

        <div class="row">
            <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">

                        <h5 class="card-title mb-0">List Contact</h5>
                    </div>
                    <div class="table-responsive">
                        <table id="contacts-table" class="table table-hover my-0 table-responsive">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Count Number</th>
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

<!-- Modal Tambah Kontak -->
<div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('contacts.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addContactModalLabel">Tambah Kontak</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="contactName" class="form-label">Nama Kontak</label>
                        <input type="text" name="name" id="contactName" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Kontak</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Phone Numbers -->
<div class="modal fade" id="phoneNumberModal" tabindex="-1" aria-labelledby="phoneNumberModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Phone Numbers <span id="contactName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" id="phoneNumbersContent">
                <div class="text-center">Loading...</div>
            </div>
        </div>
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

    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('phoneNumberModal');
        const modalBody = document.getElementById('phoneNumbersContent');
        const contactNameEl = document.getElementById('contactName');

        // Delegasi event ke document atau ke #contacts-table
        document.addEventListener('click', function (e) {
            if (e.target.closest('.btn-phone-number')) {
                e.preventDefault();
                const button = e.target.closest('.btn-phone-number');
                const contactId = button.dataset.id;
                const contactName = button.dataset.name;

                contactNameEl.textContent = contactName;
                modalBody.innerHTML = '<div class="text-center">Loading...</div>';

                fetch(`/contacts/${contactId}/phone-numbers`)
                    .then(res => res.text())
                    .then(html => {
                        modalBody.innerHTML = html;
                        feather.replace();
                    });

                // trigger modal (optional jika Bootstrap tidak otomatis buka)
                const modalInstance = new bootstrap.Modal(modal);
                modalInstance.show();
            }
        });

        // Hapus backdrop jika modal ditutup
        const modalEl = document.getElementById('phoneNumberModal');
        modalEl.addEventListener('hidden.bs.modal', function () {
            // Bersihkan semua backdrop
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());

            // Bersihkan efek scroll lock di body
            document.body.classList.remove('modal-open');
            document.body.style = '';
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        $('#contacts-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("contacts.datatable") }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'phone_numbers_count', name: 'phoneNumbers', searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });

</script>
@endsection