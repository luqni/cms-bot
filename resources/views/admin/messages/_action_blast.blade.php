<a href="{{ route('messages.edit', $campaign->id) }}" class="btn btn-sm btn-warning">
    <i data-feather="edit-3" class="me-1"></i> Edit
</a>

<a href="#" class="btn btn-sm btn-success btn-phone-number" data-bs-toggle="modal" data-bs-target="#phoneNumberModal"
    data-id="{{ $campaign->id }}"
    data-name="{{ $campaign->name }}">
    <i data-feather="phone" class="me-1"></i> Blast Campaign
</a>

<form action="{{ route('messages.destroy', $campaign->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus kontak ini?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">
        <i data-feather="trash-2" class="me-1"></i> Delete
    </button>
</form>
