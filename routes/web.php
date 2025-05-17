<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PhoneNumberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('contacts', ContactController::class);
    Route::resource('contacts', ContactController::class)->only(['index', 'store', 'destroy']);
    Route::get('contacts/{contact}/phone-numbers', [ContactController::class, 'phoneNumbers']);

    // Menampilkan form import Excel
    Route::get('/contacts/{contact_id}/phone-numbers/import', [PhoneNumberController::class, 'importForm'])
        ->name('phone-numbers.import');

    // Memproses file Excel yang di-upload
    Route::post('/contacts/{contact_id}/phone-numbers/import', [PhoneNumberController::class, 'importStore'])
        ->name('phone-numbers.import.store');

    // Menampilkan form tambah manual
    Route::get('/contacts/{contact_id}/phone-numbers/create', [PhoneNumberController::class, 'create'])
        ->name('phone-numbers.create');

    // Simpan nomor baru dari form manual
    Route::post('/contacts/{contact_id}/phone-numbers', [PhoneNumberController::class, 'store'])
        ->name('phone-numbers.store');

    Route::get('edit/{phone_number}', [PhoneNumberController::class, 'edit'])->name('phone-numbers.edit');
    Route::put('{phone_number}', [PhoneNumberController::class, 'update'])->name('phone-numbers.update');
    Route::delete('/contacts/{contact_id}/phone-numbers/{phone_number}', [PhoneNumberController::class, 'destroy'])
    ->name('phone-numbers.destroy');

});



require __DIR__.'/auth.php';

// Route::resource('contacts', ...) sudah otomatis menyediakan semua route standar termasuk:

// GET /contacts → index()

// POST /contacts → store()

// GET /contacts/create → create()

// PUT/PATCH /contacts/{contact} → update()
