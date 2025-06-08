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
                    <table class="table table-hover my-0">
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
                        <tbody>
                        @forelse ($data['list_transaksi'] as $transaksi)
                            <tr>
                                <td>{{ $transaksi['id'] }}</td>
                                <td>{{ $transaksi['nomor_hp'] }}</td>
                                <td>{{ $transaksi['deskripsi'] }}</td>
                                <td>{{ $transaksi['total'] }}</td>
                                <td>{{ $transaksi['keterangan'] }}</td>
                                <td>
                                    <a href="{{ route('transactions.edit', $transaksi['id']) }}" class="btn btn-sm btn-secondary">
                                        <i data-feather="edit-3" class="me-1"></i> Edit
                                    </a>

                                    <a href="{{ route('transactions.edit', $transaksi['id']) }}" class="btn btn-sm btn-success">
                                        <i data-feather="check-circle" class="me-1"></i> Confirm
                                    </a>

                                    <form action="{{ route('transactions.destroy', $transaksi['id']) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus kontak ini?')">
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
                                <td colspan="2">Tidak ada Transaksi.</td>
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

@endsection