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
