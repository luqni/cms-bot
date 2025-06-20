@extends('admin.layouts.app')

@section('title', 'Messages')

@section('content')
<style>
    table.dataTable {
    width: 100% !important;
}
</style>

<main class="content">
@include('admin.partials.loading')
    <div class="container-fluid p-0">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


        <h1 class="h3 mb-3">Messages</h1>

        
        <div class="card p-3 shadow">
            <nav>
                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-1" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Direct Message</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-2" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Blast Message</button>
                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-3" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">BOT Message</button>
                </div>
            </nav>

            <div class="tab-content p-3 border bg-light" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-1" role="tabpanel" aria-labelledby="nav-home-tab" >
                        <div class="row">
                            <label for="contactName" class="form-label">Pilih Kontak</label>
                            <select id="mySelect" class="form-control" name="contact_id">
                                <option value="">-- Pilih Kontak --</option>
                                @foreach($data['phoneNumbers'] as $phoneNumber)
                                    <option value="{{ $phoneNumber->number }}">{{ $phoneNumber->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr/>
                        <div class="row">
                            <label for="contactName" class="form-label">Tulis Pesanmu</label>
                            <textarea class="form-control" id="direct_message" rows="8" placeholder="Textarea"></textarea>
                        </div>

                        <hr/>
                        <div class="row">
                            <button type="button" class="btn btn-primary btn-lg" onclick="kirimDirectMessage()" >
                                Kirim
                            </button>
                        </div>
                </div>
                <div class="tab-pane fade" id="nav-2" role="tabpanel" aria-labelledby="nav-profile-tab">
                    @include('admin.messages.blast_message')
                </div>
                <div class="tab-pane fade" id="nav-3" role="tabpanel" aria-labelledby="nav-contact-tab">
                    @include('admin.messages.bot_message')
                </div>
            </div>
        </div>


    </div>
</main>
<!-- jQuery (wajib untuk Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script>
     window.addEventListener('load', function() {
        document.getElementById('loadingSpinner').style.display = 'none';
    });

    // Auto-close alert setelah 5 detik
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            // Hapus class 'show' untuk memicu animasi fade
            alert.classList.remove('show');
            alert.classList.add('fade');

            // Tunggu animasi selesai, lalu remove dari DOM
            setTimeout(() => alert.remove(), 300);
        }
    }, 5000); // 5000ms = 5 detik

    $(document).ready(function() {
        $('#mySelect').select2({
            placeholder: "Pilih kontak...",
            allowClear: true
        });
    });

    function kirimDirectMessage() {
        const contactNumber = document.getElementById('mySelect').value;
        const message = document.getElementById('direct_message').value;
        
        if (!contactNumber || !message) {
            alert('Silakan isi semua field.');
            return;
        }

        $.ajax({
            url: '{{ route("messages.directMessage") }}', // Ganti dengan route yang sesuai
            type: 'POST',
            data: {
                contact_number: contactNumber,
                message: message,
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function () {
                // Tampilkan loading jika perlu
                document.getElementById('loadingSpinner').style.display = 'flex';
                console.log('Mengirim...');
            },
            success: function (response) {
                console.log('Berhasil:', response);
                if(response.status == 201){
                    alert('Pesan berhasil dikirim!');
                    document.getElementById('loadingSpinner').style.display = 'none';
                }else{
                    alert('Pesan gagal dikirim!');
                    document.getElementById('loadingSpinner').style.display = 'none';
                }
                
            },
            error: function (xhr, status, error) {
                console.error('Gagal:', xhr.responseText);
                alert('Terjadi kesalahan saat mengirim pesan.');
                document.getElementById('loadingSpinner').style.display = 'none';
            }
        });

    }

    document.addEventListener('DOMContentLoaded', function () {
        $('#campaigns-table').DataTable().destroy(); // jika perlu reset
        $('#campaigns-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("messages.campaignDatatable") }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nama', name: 'nama' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });

    function openAddCampaignModal() {
        // Set action & method for ADD
        $('#campaignForm').attr('action', '{{ route('messages.campaignStore') }}');
        $('#formMethod').val('POST');
        $('#campaignModalLabel').text('Tambah Campaign');
        $('#submitCampaignBtn').text('Simpan');

        // Kosongkan field
        $('#campaigntName').val('');
        $('#selectContact').val('');
        $('#selectTemplate').val('');

        // Tampilkan modal
        $('#campaignModal').modal('show');
    }

    function openEditCampaigModal(id) {
        // Set action & method for EDIT

        let nama    = document.getElementById('nama_' + id).value;
        let contact_id = document.getElementById('contact_' + id).value;
        let template_id = document.getElementById('template_' + id).value;
        let url = '{{ route("messages.campaignUpdate", ":id") }}'.replace(':id', id);
        console.log(url)
        $('#campaignForm').attr('action', url);
        $('#formMethod').val('PUT');
        $('#campaignModalLabel').text('Edit Campaign');
        $('#submitCampaignBtn').text('Update');
        
        // Isi field
        $('#campaigntName').val(nama);
        $('#selectContact').val(contact_id);
        $('#selectTemplate').val(template_id);
        // Tampilkan modal
        $('#campaignModal').modal('show');
    }
    
    function blastCampaign(button) {
    const id = button.dataset.id;
    const name = button.dataset.name;
    const contact_id = button.dataset.contact;
    const template_id = button.dataset.template;
    
    if (confirm(`Yakin ingin blast campaign "${name}"?`)) {
        document.getElementById('loadingSpinner').style.display = 'flex';
        // Kirim ke route menggunakan fetch
        fetch(`/campaign/blast/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                contact_id: contact_id,
                template_id: template_id,
            })
        })
        .then(res => res.json())
        .then(data => {
            if(data.status == 201){
                alert(data.message || 'Blast Campaign : '+name+'  berhasil!');
                document.getElementById('loadingSpinner').style.display = 'none';
            }else{
                console.log(data)
                alert('Gagal Blast Pesan -> '+data.body.error);
                document.getElementById('loadingSpinner').style.display = 'none';
            }
            
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan saat blast campaign.');
            document.getElementById('loadingSpinner').style.display = 'none';
        });
    }
}

</script>

@endsection