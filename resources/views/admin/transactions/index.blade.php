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


        <h1 class="h3 mb-3">Transactions</h1>

        <div class="row">
            <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">

                        <h5 class="card-title mb-0">List Transactions</h5>
                    </div>
                    <div class="table-responsive">
                        <table id="transactions-table" class="table table-hover my-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class="d-none d-xl-table-cell">Phone Number</th>
                                    <th class="d-none d-xl-table-cell">Description</th>
                                    <th class="d-none d-xl-table-cell">Transaction Amount</th>
                                    <th class="d-none d-xl-table-cell">information</th>
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#transactions-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("transactions.datatable") }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nomor_hp', name: 'nomor_hp' },
                { data: 'deskripsi', name: 'deskripsi' },
                { data: 'total', name: 'total' },
                { data: 'keterangan', name: 'keterangan' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });
</script>

@endsection