<button class="btn btn-primary btn-sm"
        onclick="openEditCampaigModal({{ $campaign->id }})">
        <i data-feather="edit-3" class="me-1"></i> Edit
</button>

<button type="button"
    class="btn btn-sm btn-success"
    onclick="blastCampaign(this)"
    data-id="{{ $campaign->id }}"
    data-name="{{ $campaign->nama }}"
    data-contact="{{ $campaign->contact_id }}"
    data-template="{{ $campaign->template_id }}">
    <i data-feather="phone" class="me-1"></i> Blast Campaign
</button>

<form action="{{ route('messages.campaignDestroy', $campaign->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus Campaign ini?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">
        <i data-feather="trash-2" class="me-1"></i> Delete
    </button>
</form>

<input type="hidden" name="nama" id="nama_{{$campaign->id}}" value="{{ $campaign->nama }}">
<input type="hidden" name="contact_id" id="contact_{{$campaign->id}}" value="{{ $campaign->contact_id }}">
<input type="hidden" name="template_id" id="template_{{$campaign->id}}" value="{{ $campaign->template_id }}">