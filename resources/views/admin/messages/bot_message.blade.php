<h1 class="h3 mb-3">BOT Message</h1>
<div class="row">
    <div class="col-12 col-lg-12 col-xxl-12 d-flex">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0">Setting BOT</h5>
            </div>
            <div class="card-body">
                <!-- <div class="container mt-5"> -->
                    <form class="row g-3 align-items-center">
                    <input type="hidden" id="id" name="id" class="form-control" value="{{ old('id', $data['bot'][0]['id'] ?? '') }}">
                        <div class="row">
                            <div class="col-auto">
                                <label for="nama" class="col-form-label">Nama BOT </label>
                            </div>
                            <div class="col-auto">
                                <input type="text" id="name_bot" name="name_bot" class="form-control" placeholder="Masukkan nama" value="{{ old('name_bot', $data['bot'][0]['name'] ?? '') }}">
                            </div>
                        </div>
                        <div row="row">
                            <div class="col-auto">
                                <label for="instruksi" class="col-form-label">Instruksi </label>
                            </div>
                            <div class="col-auto">
                                <textarea class="form-control" id="knowledge_bot" name="knowledge_bot" rows="8" placeholder="Kamu adalah Asisten Pribadi...">{{ old('knowledge_bot', $data['bot'][0]['knowledge'] ?? '') }}</textarea>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <button type="button" class="btn btn-success btn-lg" onclick="simpanData()" >
                                Simpan
                            </button>
                        </div>

                    </form>
                <!-- </div> -->
            </div>
        </div>
    </div>
</div>

<script>
    function simpanData() {
        const nameBot = document.getElementById('name_bot').value;
        const knowledgeBot = document.getElementById('knowledge_bot').value;
        const id = document.getElementById('id').value;

        console.log(nameBot+'---'+knowledgeBot)
        $.ajax({
            url: '{{ route("messages.setChatBot") }}', // Ganti dengan route yang sesuai
            type: 'POST',
            data: {
                id,
                nameBot,
                knowledgeBot,
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function () {
                // Tampilkan loading jika perlu
                console.log('Mengirim...');
            },
            success: function (response) {
                console.log('Berhasil:', response);
                if(response.status == 200){
                    
                    location.reload();
                }else{
                    alert('Data gagal disimpan!');
                    location.reload();
                }
                
            },
            error: function (xhr, status, error) {
                console.error('Gagal:', xhr.responseText);
                alert('Terjadi kesalahan saat menyimpan data.');
            }
        });
    }
</script>