@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<main class="content">

    <div class="container-fluid p-0">

        <h4>Import Nomor Telepon dari Excel - {{ $contact->name }}</h4>

        <form action="{{ route('phone-numbers.import.store', $contact) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="file" class="form-label">Pilih File Excel (.xls atau .xlsx)</label>
                <input type="file" name="file" id="file" 
                    class="form-control @error('file') is-invalid @enderror" 
                    accept=".xls,.xlsx" required>
                @error('file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <i data-feather="upload" class="me-1"></i> Upload & Import
            </button>
            <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</main>
@endsection
