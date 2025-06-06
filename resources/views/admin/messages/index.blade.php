@extends('admin.layouts.app')

@section('title', 'Messages')

@section('content')

<main class="content">
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
                <div class="tab-pane fade active show" id="nav-1" role="tabpanel" aria-labelledby="nav-home-tab">
                    <!-- <p><strong>This is some placeholder content the Home tab's associated content.</strong>
                        Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps
                        classes to control the content visibility and styling. You can use it with tabs, pills, and any
                        other <code>.nav</code>-powered navigation.</p> -->
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

                        <button type="button" class="btn btn-primary btn-lg" onclick="kirimDirectMessage()" >
                            Kirim
                        </button>
                </div>
                <div class="tab-pane fade" id="nav-2" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <p><strong>This is feature on Progress.</strong></p>
                </div>
                <div class="tab-pane fade" id="nav-3" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <p><strong>This is feature on Progress.</strong></p>
                </div>
            </div>
        </div>


    </div>
</main>
<!-- jQuery (wajib untuk Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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
                console.log('Mengirim...');
            },
            success: function (response) {
                console.log('Berhasil:', response);
                if(response.status == 201){
                    alert('Pesan berhasil dikirim!');
                }else{
                    alert('Pesan gagal dikirim!');
                }
                
            },
            error: function (xhr, status, error) {
                console.error('Gagal:', xhr.responseText);
                alert('Terjadi kesalahan saat mengirim pesan.');
            }
        });

    }
</script>

@endsection