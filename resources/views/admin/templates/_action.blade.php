<button class="btn btn-primary btn-sm"
        onclick="openEditTemplateModal({{ $template->id }})">
        <i data-feather="edit-3" class="me-1"></i> Edit
</button>

<form action="{{ route('templates.destroy', $template->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus kontak ini?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">
        <i data-feather="trash-2" class="me-1"></i> Delete
    </button>
</form>
</td>
<input type="hidden" name="content" id="content_{{$template->id}}" value="{{ addslashes($template->content) }}">
<input type="hidden" name="name" id="name_{{$template->id}}" value="{{ $template->name }}">