<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\NodeApiService;

class DashboardController extends Controller
{
    protected $nodeApi;

    public function __construct(NodeApiService $nodeApi)
    {
        $this->nodeApi = $nodeApi;
    }

    public function index()
    {
        
        // $data = [
        //     'email' => auth()->user()->email
        // ];

        $email = auth()->user()->email;
        // $email = 'berjibakutech';

        $response = $this->nodeApi->get('/api/sessions/'.$email);
        $getSessions = [
            'status' => $response->status(),
            'body' => $response->json()
        ];

        // dd($getSessions);
        return view('admin.dashboard', compact('getSessions'));
    }

    public function createSession(){
        $payload = [
            "name" => auth()->user()->email,
            "start" => true,
            "config" => [
                "proxy" => null,
                "debug" => false,
                "noweb" => [
                    "store" => [
                        "enabled" => true,
                        "fullSync" => false
                    ]
                ],
                "webhooks" => [
                    [
                        "url" => "https://webhook.site/11111111-1111-1111-1111-11111111",
                        "events" => [
                            "message",
                            "session.status"
                        ],
                        "hmac" => null,
                        "retries" => null,
                        "customHeaders" => null
                    ]
                ]
            ]
        ];

        $response = $this->nodeApi->post('/api/sessions', $payload);
        
        $createdSession = [
            'status' => $response->status(),
            'body' => $response->json()
        ];

        return response()->json($createdSession);

    }

    public function generateQrcodeWa(Request $request)
    {
        $email = auth()->user()->email;
        
        $response = $this->nodeApi->get('/api/'.$email.'/auth/qr');
        
        // Ambil konten gambar dari response
        $imageContent = $response->body(); // <-- ini binary PNG

        // Encode ke base64
        $base64 = base64_encode($imageContent);

        // Buat data URI (agar bisa langsung ditampilkan di img src)
        $dataUri = 'data:image/png;base64,' . $base64;

        return response()->json([
            'status' => $response->status(),
            'qr_code' => $dataUri
        ]);
    }


    public function startSession(Request $request)
    {
        $email = auth()->user()->email;
        
        $response = $this->nodeApi->post('/api/sessions/'.$email.'/start');

        $generateQrcode = [
            'status' => $response->status(),
            'body' => $response->json()
        ];

        return response()->json($generateQrcode);
    }

    public function reStartSession(Request $request)
    {
        dd('masuuuk');
        $email = auth()->user()->email;
        
        $response = $this->nodeApi->post('/api/sessions/'.$email.'/restart');

        $generateQrcode = [
            'status' => $response->status(),
            'body' => $response->json()
        ];

        return response()->json($generateQrcode);
    }
}
