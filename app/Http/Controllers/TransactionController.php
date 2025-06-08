<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TransactionController extends Controller
{

    public function index()
    {
        $data = [];

        $responseSupabase = Http::withHeaders([
            'apikey' => env('SUPABASE_ANON_KEY'),
            'Authorization' => 'Bearer ' . env('SUPABASE_ANON_KEY'),
        ])->get(env('SUPABASE_URL') . '/rest/v1/transaction_detail', [
            'select' => '*'
        ]);

        if($responseSupabase){
            $transaksi = $responseSupabase->json();
            $data['list_transaksi'] = $transaksi;
        }

        // dd($data);

        return view('admin.transactions.index', compact('data'));
    }

}
