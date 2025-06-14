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
use App\Services\SupabaseService;

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

        $responseSupabase = SupabaseService::get('bot_settings', ['select' => '*',
            'user_email' => 'eq.'.auth()->user()->email]);

        if($responseSupabase){
            $data['bot'] =  $responseSupabase->json();
        }

        $responseGetSession = $this->nodeApi->get('/api/sessions/'.auth()->user()->email);

        $getSessionWaApi = [
            'status' => $responseGetSession->status(),
            'body' => $responseGetSession->json()
        ];


        if($getSessionWaApi['status'] == 200){
            $data['session_wa_api'] = $getSessionWaApi['body'];

            $data['url_webhooks'] = $getSessionWaApi['body']['config']['webhooks'][0]['url'];
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

    public function campaignStore(Request $request)
    {

        Campaign::create([
            'nama'          => $request->nama,
            'contact_id'    => $request->contact_id,
            'template_id'   => $request->template_id,
            'user_id'       => auth()->id(),
        ]);

        return redirect()->route('messages.index')->with('success', 'Campaign berhasil ditambahkan.');
    }

    public function campaignUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'contact_id' => 'required',
            'template_id' => 'required',
        ]);


        $campaign = Campaign::findOrFail($id);
       
        $campaign->update($request->only('nama', 'contact_id', 'template_id'));

        return redirect()->route('messages.index')->with('success', 'Campaign berhasil diedit.');
    }

    public function campaignDestroy(Request $request, $id)
    {
        
        $campaign = Campaign::findOrFail($id);
        $campaign->delete();

        return redirect()->route('messages.index')->with('success', 'Campaign berhasil dihapus.');
    }

    public function blastCampaign(Request $request, $id)
    {
        $contact_id = $request->contact_id;
        $template_id = $request->template_id;

        $template = Template::where('id', $template_id)->get();
        
        $phoneNumber = PhoneNumber::where('contact_id', $contact_id)->get();

        $content = '';

        if($template){
            foreach($template as $key => $value){
                $content = $value->content;
            }
        }
        
        if($phoneNumber && $template){
            foreach($phoneNumber as $key => $value){
                
                $payload = [
                    "chatId"                    => $value->number,
                    "reply_to"                  => null,
                    "text"                      => $content,
                    "linkPreview"               => true,
                    "linkPreviewHighQuality"    => false,
                    "session"                   => auth()->user()->email
                        
                ];

                $response = $this->nodeApi->post('/api/sendText', $payload);

                $createdSession = [
                    'status' => $response->status(),
                    'body' => $response->json()
                ];

                sleep(2);
            }
        }

        
        return response()->json($createdSession);
    }

    public function setChatBot(Request $request)
    {
        
        $dataInsert = [
            'name'      => $request->nameBot,
            'knowledge' => $request->knowledgeBot,
            'user_email'=> auth()->user()->email,
        ];

        if($request->id){
            
            $filters = ['id' => 'eq.'.$request->id];
            $dataUpdate = [$dataInsert ];

            $response = SupabaseService::update('bot_settings', $filters, $dataUpdate);

        }else{
            $response = SupabaseService::insert('bot_settings', $dataInsert);
        }

        // https://n8n.oasis.my.id/webhook/469a91cd-9cfe-47b0-b897-ab93b131db14

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
                        "url" => "https://n8n.oasis.my.id/webhook/469a91cd-9cfe-47b0-b897-ab93b131db14",
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

        $responseUpdateSession = $this->nodeApi->put('/api/sessions/'.auth()->user()->email, $payload);

        if ($response->successful() && $responseUpdateSession ) {
            return response()->json([
                'status'  => 200,
                'message' => 'Data berhasil disimpan',
            ]);
        } else {
            return response()->json([
                'status'  => 500,
                'message' => 'Gagal simpan',
                'error' => $response->body()
            ], $response->status());
        }
    }

    public function updateSessionWaApi(Request $request)
    {

        $webhooks = "https://webhook.site/11111111-1111-1111-1111-11111111";

        if($request->status === "on"){
            $webhooks = 'https://n8n.oasis.my.id/webhook/469a91cd-9cfe-47b0-b897-ab93b131db14';
        }

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
                        "url" => $webhooks,
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

        $responseUpdateSession = $this->nodeApi->put('/api/sessions/'.auth()->user()->email, $payload);

        return true;
    }

}
