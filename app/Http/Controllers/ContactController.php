<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    public function index()
    {
        // Ambil semua kontak milik user yang sedang login
        $contacts = Contact::where('user_id', Auth::id())
                ->withCount('phoneNumbers')
                ->get();

        return view('admin.contacts.index', compact('contacts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Contact::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('contacts.index')->with('success', 'Kontak berhasil ditambahkan.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('contacts.index')->with('success', 'Kontak berhasil dihapus.');
    }

    public function phoneNumbers(Contact $contact)
    {
        $contact->load('phoneNumbers'); // relasi eager loading

        return view('partials.contacts.phone-numbers', compact('contact'));
    }

    public function datatable()
    {
        $contacts = Contact::where('user_id', Auth::id())
            ->withCount('phoneNumbers');

        return DataTables::of($contacts)
            ->addColumn('action', function ($contact) {
                return view('admin.contacts._action', compact('contact'))->render();
            })
            ->rawColumns(['action'])
            ->make(true);
    }

}
