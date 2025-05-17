@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <h4>Tambah Nomor Telepon Manual untuk Kontak: {{ $contact->name }}</h4>

        <form action="{{ route('phone-numbers.store', $contact) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" name="name" id="name" 
                    class="form-control @error('name') is-invalid @enderror" 
                    value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="number" class="form-label">Nomor Telepon</label>
                <input type="text" name="number" id="number" 
                    class="form-control @error('number') is-invalid @enderror" 
                    value="{{ old('number') }}" required>
                @error('number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">
                <i data-feather="plus" class="me-1"></i> Simpan Nomor
            </button>
            <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</main>
@endsection
