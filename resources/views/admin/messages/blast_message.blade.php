<h1 class="h3 mb-3">Campaign</h1>

<!-- Tombol Trigger Modal -->
<button class="btn btn-primary mb-3" onclick="openAddCampaignModal()">
    + Tambah Campaign
</button>

<div class="row">
    <div class="col-12 col-lg-12 col-xxl-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header">

                <h5 class="card-title mb-0">List Campaign</h5>
            </div>
            <div class="table-responsive">
                <table id="campaigns-table" class="table table-hover my-0" style="width: 100px;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>        
                </table>
            </div>
        </div>
    </div>
</div>

 

<!-- Modal Tambah Campaign -->
<div class="modal fade" id="campaignModal" tabindex="-1" aria-labelledby="campaignModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="campaignForm" method="POST">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="campaignModalLabel">Tambah Campaign</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="contactName" class="form-label">Nama Campaign</label>
                        <input type="text" name="nama" id="campaigntName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="contactName" class="form-label">Contact</label>
                        <select id="selectContact" class="form-control" name="contact_id">
                            <option value="">-- Pilih Kontak --</option>
                            @foreach($data['contacts'] as $contact)
                                <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="contactName" class="form-label">Template</label>
                        <select id="selectTemplate" class="form-control" name="template_id">
                            <option value="">-- Pilih Template --</option>
                            @foreach($data['templates'] as $templat)
                                <option value="{{ $templat->id }}">{{ $templat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitCampaignBtn">Simpan Campaign</button>
                </div>
            </div>
        </form>
    </div>
</div>