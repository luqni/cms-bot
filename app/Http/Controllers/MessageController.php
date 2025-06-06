<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\NodeApiService;

class MessageController extends Controller
{

    protected $nodeApi;

    public function __construct(NodeApiService $nodeApi)
    {
        $this->nodeApi = $nodeApi;
    }

    public function index()
    {
        $data = [];

        $phoneNumbers = \App\Models\PhoneNumber::whereHas('contact', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        if($phoneNumbers){
            $data['phoneNumbers'] = $phoneNumbers;
        }

        // dd($data);

        return view('admin.messages.index', compact('data'));
    }

    public function directMessage(Request $request)
    {
        // dd($request->contact_number);

        // "chatId": "11111111111@c.us",
        // "reply_to": null,
        // "text": "Hi there!",
        // "linkPreview": true,
        // "linkPreviewHighQuality": false,
        // "session": "default"

        $payload = [
            "chatId"                    => $request->contact_number,
            "reply_to"                  => null,
            "text"                      => $request->message,
            "linkPreview"               => true,
            "linkPreviewHighQuality"    => false,
            "session"                   => auth()->user()->email
                
        ];

        
        $response = $this->nodeApi->post('/api/sendText', $payload);
        
        $createdSession = [
            'status' => $response->status(),
            'body' => $response->json()
        ];


        return response()->json($createdSession);


    }

}
