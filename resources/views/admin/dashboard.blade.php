@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- <h1 class="h2">Admin Dashboard</h1>
    <p>Selamat datang, {{ auth()->user()->name }}!</p> -->
    <div id="loadingSpinner" class="text-center my-3" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <main class="content">
        <div class="container-fluid p-0">

            <h1 class="h3 mb-3">Dashboard</h1>

            <div class="row">
                <div class="col-xl-6 col-xxl-5 d-flex">
                    <div class="w-100">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Connection Status</h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="wifi"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-0">
                                            @if($data['session']['status'] == 200)
                                                @if($data['session']['body']['status'] == 'SCAN_QR_CODE')
                                                    <h2>{{ $data['session']['body']['status'] }}</h2>
                                                    <hr/>
                                                    <label>Silahkan Klik Scan QR Code untuk memulai session</label>
                                                    <hr/>
                                                    <button type="button" class="btn btn-primary btn-lg" onclick="getQrcode()" >
                                                        Scan Qr Code
                                                    </button>
                                                    <hr/>
                                                    <div class="image-qrcode"></div>
                                                    <!-- <img id="qrImage" src="" alt="QR Code" /> -->
                                                @endif
                                                @if($data['session']['body']['status'] == 'STOPPED')
                                                    <h2 style="color:red;">{{ $data['session']['body']['status'] }}</h2>
                                                    <hr/>
                                                    <label>Session anda berhenti silahkan click Start untuk memulai kembali</label>
                                                    <hr/>
                                                    <button type="button" class="btn btn-success btn-lg" onclick="startSession()" >
                                                        START
                                                    </button>
                                                @endif
                                                @if($data['session']['body']['status'] == 'FAILED')
                                                    <h2 style="color:red;">{{ $data['session']['body']['status'] }}</h2>
                                                    <hr/>
                                                    <label>Session Anda Gagal di Buat Silahkan Klik Tombol Restart</label>
                                                    <hr/>
                                                    <button type="button" class="btn btn-success btn-lg" onclick="reStartSession()" >
                                                        RE-START
                                                    </button>
                                                @endif
                                                @if($data['session']['body']['status'] == 'WORKING')
                                                    <h2 style="color:green;">{{ $data['session']['body']['status'] }}</h2>
                                                    <hr/>
                                                    <label>WhatsApp Anda Sudah Terhubung... </label>
                                                    <hr/>
                                                @endif
                                                @if($data['session']['body']['status'] == 'STARTING')
                                                    <h2 style="color:green;">{{ $data['session']['body']['status'] }}</h2>
                                                    <hr/>
                                                    <label>Session Anda Terbuat Silahkan Klik Tombol Refresh</label>
                                                    <hr/>
                                                    <button type="button" class="btn btn-success btn-lg" onclick="refresh()" >
                                                        REFRESH
                                                    </button>
                                                @endif
                                            @endif
                                            @if($data['session']['status'] == 404)
                                                <h2 style="color:red;">{{ $data['session']['body']['message'] }}</h2>
                                                <hr/>
                                                <label>Session Tidak Tersedia, Silahkan Buat Session Baru dengan Klik Buat Session</label>
                                                <hr/>
                                                <button type="button" class="btn btn-success btn-lg" onclick="createSession()" >
                                                    Buat Session
                                                </button>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function createSession() {
            $.ajax({
            url: "{{ route('dashboard.createSession') }}",   // ganti dengan URL API-mu
            method: 'GET',
            success: function(response) {
                if(response.status == 201){
                    location.reload();
                }
               
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
            });
        }

        function getQrcode() {
            $.ajax({
            url: "{{ route('dashboard.generateQrcodeWa') }}",   // ganti dengan URL API-mu
            method: 'GET',
            success: function(response) {
                if(response.status == 200){
                    var imgTag = `<img id="qrImage" src="${response.qr_code}" alt="QR Code" />`;

                    // Sisipkan ke dalam div.image-qrcode
                    $('.image-qrcode').html(imgTag);
                }
               
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
            });
        }

        function startSession() {

            $.ajax({
            url: "{{ route('dashboard.startSession') }}",   // ganti dengan URL API-mu
            method: 'GET',
            success: function(response) {
                if(response.status == 200){
                    location.reload();
                }
               
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            },

            });
        }

        function reStartSession() {

            $.ajax({
            url: "{{ route('dashboard.reStartSession') }}",   // ganti dengan URL API-mu
            method: 'GET',
            success: function(response) {
                if(response.status == 201){
                    location.reload();
                }
               
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            },

            });
        }

        function refresh() {
            location.reload();
        }

    </script>
@endsection
