<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;
use App\Imports\PhoneNumberImport;
use Maatwebsite\Excel\Facades\Excel;

class PhoneNumberController extends Controller
{
    // Tampilkan form import Excel
    public function importForm($contact_id)
    {
        $contact = Contact::findOrFail($contact_id);
        return view('admin.phone-numbers.import', compact('contact'));
    }

    // Proses upload dan import Excel
    public function importStore(Request $request, $contact_id)
    {
        $contact = Contact::findOrFail($contact_id);

        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new PhoneNumberImport($contact->id), $request->file('file'));

        return redirect()->route('contacts.index')
            ->with('success', 'Nomor telepon berhasil diimpor.');
    }

    // Tampilkan form tambah manual nomor telepon
    public function create($contact_id)
    {
        $contact = Contact::findOrFail($contact_id);
        return view('admin.phone-numbers.create', compact('contact'));
    }

    // Simpan nomor telepon baru manual ke DB
    public function store(Request $request, $contact_id)
    {
        $contact = Contact::findOrFail($contact_id);

        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:50',
        ]);

        $contact->phoneNumbers()->create([
            'name' => $request->name,
            'number' => $request->number,
        ]);

        return redirect()->route('contacts.index')
            ->with('success', 'Nomor telepon berhasil ditambahkan.');
    }

    public function edit($contact_id, $phone_number_id)
    {
        $contact = Contact::findOrFail($contact_id);
        $phoneNumber = PhoneNumber::where('contact_id', $contact->id)->findOrFail($phone_number_id);

        return view('admin.phone-numbers.edit', compact('contact', 'phoneNumber'));
    }

    public function update(Request $request, $contact_id, $phone_number_id)
    {
        $contact = Contact::findOrFail($contact_id);
        $phoneNumber = PhoneNumber::where('contact_id', $contact->id)->findOrFail($phone_number_id);

        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:50',
        ]);

        $phoneNumber->update([
            'name' => $request->name,
            'number' => $request->number,
        ]);

        return redirect()->route('contacts.index')
            ->with('success', 'Nomor telepon berhasil diperbarui.');
    }

    public function destroy($contact_id, $phone_number_id)
    {
        $contact = Contact::findOrFail($contact_id);
        $phoneNumber = PhoneNumber::where('contact_id', $contact->id)->findOrFail($phone_number_id);

        $phoneNumber->delete();

        return redirect()->route('contacts.index')
            ->with('success', 'Nomor telepon berhasil dihapus.');
    }
}

