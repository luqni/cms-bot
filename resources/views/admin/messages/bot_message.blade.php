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
                                <label class="form-check-label" for="flexSwitchCheckChecked">Status Bot Aktif</label>
                            </div>
                            <div class="col-auto">
                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked">
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-auto">
                                <label for="nama" class="col-form-label"><b>Nama BOT</b></label>
                            </div>
                            <div class="col-auto">
                                <input type="text" id="name_bot" name="name_bot" class="form-control" placeholder="Masukkan nama" value="{{ old('name_bot', $data['bot'][0]['name'] ?? '') }}">
                            </div>
                        </div>
                        <div row="row">
                            <div class="col-auto">
                                <label for="instruksi" class="col-form-label"><b>Instruksi</b></label>
                            </div>
                            <div class="col-auto">
                                <textarea class="form-control" id="knowledge_bot" name="knowledge_bot" rows="8" placeholder="Kamu adalah Asisten Pribadi...">{{ old('knowledge_bot', $data['bot'][0]['knowledge'] ?? '') }}</textarea>
                            </div>
                        </div class="row">
                            <div class="col-auto">
                                <label for="import" class="col-form-label"><b>Upload Data Excel</b></label>
                            </div>
                            <div class="col-auto">
                            <input type="file" id="excelFile" name="excel_file" accept=".xlsx,.xls,.csv">
                            </div>
                        <div>

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
        const excelFile = document.getElementById('excelFile').files[0];
        document.getElementById('loadingSpinner').style.display = 'flex';

        const formData = new FormData();
        formData.append('id', id);
        formData.append('nameBot', nameBot);
        formData.append('knowledgeBot', knowledgeBot);
        formData.append('_token', '{{ csrf_token() }}');

        // Tambahkan file jika dipilih
        if (excelFile) {
            formData.append('excel_file', excelFile);
        }

        $.ajax({
            url: '{{ route("messages.setChatBot") }}', // Ganti dengan route yang sesuai
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                // Tampilkan loading jika perlu
                document.getElementById('loadingSpinner').style.display = 'flex';
                console.log('Mengirim...');
            },
            success: function (response) {
                console.log('Berhasil:', response);
                if(response.status == 200){
                    document.getElementById('loadingSpinner').style.display = 'none';
                    location.reload();
                }else{
                    alert('Data gagal disimpan!');
                    document.getElementById('loadingSpinner').style.display = 'none';
                    location.reload();
                }
                
            },
            error: function (xhr, status, error) {
                console.error('Gagal:', xhr.responseText);
                alert('Terjadi kesalahan saat menyimpan data.');
                document.getElementById('loadingSpinner').style.display = 'none';
            }
        });
    }

    document.getElementById('flexSwitchCheckChecked').addEventListener('change', function() {
        if (this.checked) {
            updateSession("on");
            console.log('Checkbox baru saja DICENTANG');
        } else {
            updateSession("off");
            console.log('Checkbox baru saja DIBATALKAN');
        }
    });

    const checkbox = document.getElementById('flexSwitchCheckChecked');
    if(@json($data['url_webhooks']) === "https://webhook.site/11111111-1111-1111-1111-11111111"){
        checkbox.checked = false;
    }else{
        checkbox.checked = true;
    }

    function updateSession(status){
        document.getElementById('loadingSpinner').style.display = 'flex';
        $.ajax({
            url: '{{ route("messages.updateSessionWaApi") }}', // Ganti dengan route yang sesuai
            type: 'POST',
            data: {
                status,
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function () {
                // Tampilkan loading jika perlu
                document.getElementById('loadingSpinner').style.display = 'flex';
                console.log('Mengirim...');
            },
            success: function (response) {
                console.log('Berhasil:', response);
                if(response){
                    document.getElementById('loadingSpinner').style.display = 'none';
                    location.reload();
                }else{
                    alert('Data gagal disimpan!');
                    document.getElementById('loadingSpinner').style.display = 'none';
                    location.reload();
                }
                
            },
            error: function (xhr, status, error) {
                console.error('Gagal:', xhr.responseText);
                alert('Terjadi kesalahan saat menyimpan data.');
                document.getElementById('loadingSpinner').style.display = 'none';
            }
        });
    }
</script>