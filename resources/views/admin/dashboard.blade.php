@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- <h1 class="h2">Admin Dashboard</h1>
    <p>Selamat datang, {{ auth()->user()->name }}!</p> -->
    <main class="content">
        <div class="container-fluid p-0">

            <h1 class="h3 mb-3">Dashboard</h1>

            <div class="row">
                <div class="col-xl-6 col-xxl-5 d-flex">
                    <div class="w-100">
                        <div class="row">
                            <div class="col-sm-6">
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
                                            @if($getSessions['status'] == 404 && $getSessions['body'])
                                                @if($getSessions['status'] == 404)
                                                    <div>{{ $getSessions['body']['message'] }}</div>
                                                @else
                                                    <div>{{ $getSessions['body']['status'] }}</div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($getSessions['status'] == 404)
                            <div class="col-sm-6">
                                <div class="card" onclick="createSession()" style="cursor: pointer;">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Click For Create Session</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($getSessions['status'] == 200 && $getSessions['body']['status'] == 'SCAN_QR_CODE')
                            <div class="col-sm-6">
                                <div class="card" onclick="getQrcode()" style="cursor: pointer;">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Click For Get QRCODE</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
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
                if(response.status == 201){
                    location.reload();
                }
               
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
            });
        }
    </script>
@endsection
