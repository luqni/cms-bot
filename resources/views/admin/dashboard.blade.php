@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- <h1 class="h2">Admin Dashboard</h1>
    <p>Selamat datang, {{ auth()->user()->name }}!</p> -->
    @include('admin.partials.loading')
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
                <!-- <div class="col-xl-6 col-xxl-5 d-flex">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Transaction Count</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign align-middle"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">$21.300</h1>
                            <div class="mb-0">
                                <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i> 6.65% </span>
                                <span class="text-muted">Since last week</span>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>

        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function createSession() {
            document.getElementById('loadingSpinner').style.display = 'flex';
            $.ajax({
            url: "{{ route('dashboard.createSession') }}",   // ganti dengan URL API-mu
            method: 'GET',
            success: function(response) {
                if(response.status == 201){
                    document.getElementById('loadingSpinner').style.display = 'none';
                    location.reload();
                }
               
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                document.getElementById('loadingSpinner').style.display = 'none';
            }
            });
        }

        function getQrcode() {
            document.getElementById('loadingSpinner').style.display = 'flex';
            $.ajax({
            url: "{{ route('dashboard.generateQrcodeWa') }}",   // ganti dengan URL API-mu
            method: 'GET',
            success: function(response) {
                if(response.status == 200){
                    document.getElementById('loadingSpinner').style.display = 'none';
                    var imgTag = `<img id="qrImage" src="${response.qr_code}" alt="QR Code" />`;

                    // Sisipkan ke dalam div.image-qrcode
                    $('.image-qrcode').html(imgTag);
                }
               
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                document.getElementById('loadingSpinner').style.display = 'none';
            }
            });
        }

        function startSession() {
            document.getElementById('loadingSpinner').style.display = 'flex';
            $.ajax({
            url: "{{ route('dashboard.startSession') }}",   // ganti dengan URL API-mu
            method: 'GET',
            success: function(response) {
                if(response.status == 201){
                    document.getElementById('loadingSpinner').style.display = 'none';
                    location.reload();
                }
               
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                document.getElementById('loadingSpinner').style.display = 'none';
            },

            });
        }

        function reStartSession() {
            document.getElementById('loadingSpinner').style.display = 'flex';
            $.ajax({
            url: "{{ route('dashboard.reStartSession') }}",   // ganti dengan URL API-mu
            method: 'GET',
            success: function(response) {
                if(response.status == 201){
                    document.getElementById('loadingSpinner').style.display = 'none';
                    location.reload();
                }
               
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                document.getElementById('loadingSpinner').style.display = 'none';
            },

            });
        }

        function refresh() {
            location.reload();
        }

    </script>
@endsection
