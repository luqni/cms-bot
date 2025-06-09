<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\PhoneNumber;
use App\Models\Campaign;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\NodeApiService;
use Yajra\DataTables\Facades\DataTables;

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

        $contacts = Contact::where('user_id', Auth::id())->get();
        if($contacts){
            $data['contacts'] = $contacts;
        }

        $templates = Template::where('user_id', Auth::id())->get();
        if($templates){
            $data['templates'] = $templates;
        }


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

    public function campaignDatatable()
    {
        $campaigns = Campaign::where('user_id', Auth::id())->get();

        return DataTables::of($campaigns)
            ->addColumn('action', function ($campaign) {
                return view('admin.messages._action_blast', compact('campaign'))->render();
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_id' => 'required',
            'template_id' => 'required',
        ]);

        Campaign::create([
            'nama'          => $request->name,
            'contact_id'    => $request->contact_id,
            'template_id'   => $request->template_id,
            'user_id'       => auth()->id(),
        ]);

        return redirect()->route('messages.index')->with('success', 'Campaign berhasil ditambahkan.');
    }

}
