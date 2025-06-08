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