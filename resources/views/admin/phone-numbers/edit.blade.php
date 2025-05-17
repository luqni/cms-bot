@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h4>Edit Nomor Telepon untuk Kontak: {{ $contact->name }}</h4>

    <form action="{{ route('phone-numbers.update', ['contact_id' => $contact->id, 'phone_number' => $phoneNumber->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" 
                   class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', $phoneNumber->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="number" class="form-label">Nomor Telepon</label>
            <input type="text" name="number" id="number" 
                   class="form-control @error('number') is-invalid @enderror" 
                   value="{{ old('number', $phoneNumber->number) }}" required>
            @error('number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-warning">
            <i data-feather="edit-3" class="me-1"></i> Update
        </button>
        <a href="{{ route('contacts.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
