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
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="d-none d-xl-table-cell">Name</th>
                                <th class="d-none d-xl-table-cell">Count Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($contacts as $contact)
                            <tr>
                                <td>{{ $contact->id }}</td>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->phone_numbers_count }}</td>
                                <td>
                                <a href="{{ route('contacts.edit', $contact->id) }}" class="btn btn-sm btn-warning">
                                    <i data-feather="edit-3" class="me-1"></i> Edit
                                </a>

                                <a href="#" class="btn btn-sm btn-success btn-phone-number" data-bs-toggle="modal" data-bs-target="#phoneNumberModal"
                                    data-id="{{ $contact->id }}"
                                    data-name="{{ $contact->name }}">
                                    <i data-feather="phone" class="me-1"></i> Phone Number
                                </a>

                                <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus kontak ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i data-feather="trash-2" class="me-1"></i> Delete
                                    </button>
                                </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">Tidak ada kontak.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
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
        document.querySelectorAll('.btn-phone-number').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const contactId = this.dataset.id;
                const contactName = this.dataset.name;

                document.getElementById('contactName').textContent = contactName;
                const modalBody = document.getElementById('phoneNumbersContent');
                modalBody.innerHTML = '<div class="text-center">Loading...</div>';

                // Fetch data dari route Laravel (pastikan route dibuat)
                fetch(`/contacts/${contactId}/phone-numbers`)
                    .then(res => res.text())
                    .then(html => {
                        modalBody.innerHTML = html;
                        feather.replace(); // render ulang icon feather
                    });
            });
        });
    });

</script>
@endsection