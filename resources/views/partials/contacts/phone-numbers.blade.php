@if($contact->phoneNumbers->isEmpty())
    <div class="alert alert-info">Belum ada nomor telepon.</div>
    <a href="{{ route('phone-numbers.import', $contact->id) }}" class="btn btn-primary">
        <i data-feather="upload" class="me-1"></i> Import dari Excel
    </a>
    <a href="{{ route('phone-numbers.create', ['contact_id' => $contact->id]) }}" class="btn btn-success">
        <i data-feather="plus" class="me-1"></i> Tambah Manual
    </a>
@else
    <a href="{{ route('phone-numbers.import', $contact->id) }}" class="btn btn-primary">
        <i data-feather="upload" class="me-1"></i> Import dari Excel
    </a>
    <a href="{{ route('phone-numbers.create', ['contact_id' => $contact->id]) }}" class="btn btn-success">
        <i data-feather="plus" class="me-1"></i> Tambah Manual
    </a>
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Nomor</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contact->phoneNumbers as $number)
            <tr>
                <td>{{ $number->name }}</td>
                <td>{{ $number->number }}</td>
                <td>
                    <a href="{{ route('phone-numbers.edit', ['contact_id' => $contact->id, 'phone_number' => $number->id]) }}" class="btn btn-sm btn-warning">
                        <i data-feather="edit-3" class="me-1"></i> Edit
                    </a>
                    <form action="{{ route('phone-numbers.destroy', ['contact_id' => $contact->id, 'phone_number' => $number->id]) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus nomor ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i data-feather="trash-2" class="me-1"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif
