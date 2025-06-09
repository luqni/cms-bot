<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PhoneNumberController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TransactionController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    //Menu Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('contacts', ContactController::class);
    Route::resource('contacts', ContactController::class)->only(['index', 'store', 'destroy']);
    Route::get('contacts/{contact}/phone-numbers', [ContactController::class, 'phoneNumbers']);

    //Menu Kontak
    // Menampilkan form import Excel
    Route::get('/contacts/{contact_id}/phone-numbers/import', [PhoneNumberController::class, 'importForm'])
        ->name('phone-numbers.import');
    // Memproses file Excel yang di-upload
    Route::post('/contacts/{contact_id}/phone-numbers/import', [PhoneNumberController::class, 'importStore'])
        ->name('phone-numbers.import.store');
    // Menampilkan form tambah manual
    Route::get('/contacts/{contact_id}/phone-numbers/create', [PhoneNumberController::class, 'create'])
        ->name('phone-numbers.create');
    Route::get('/admin/contacts/datatable', [ContactController::class, 'datatable'])->name('contacts.datatable');

    // Simpan nomor baru dari form manual
    Route::post('/contacts/{contact_id}/phone-numbers', [PhoneNumberController::class, 'store'])
        ->name('phone-numbers.store');
    Route::get('edit/{phone_number}', [PhoneNumberController::class, 'edit'])->name('phone-numbers.edit');
    Route::put('{phone_number}', [PhoneNumberController::class, 'update'])->name('phone-numbers.update');
    Route::delete('/contacts/{contact_id}/phone-numbers/{phone_number}', [PhoneNumberController::class, 'destroy'])
    ->name('phone-numbers.destroy');

    //Menu Template
    Route::resource('templates', TemplateController::class);
    Route::get('/admin/templates/datatable', [TemplateController::class, 'datatable'])->name('templates.datatable');

    //Menu Dashboard
    Route::get('get-session-api', [DashboardController::class, 'createSession'])->name('dashboard.createSession');
    Route::get('get-qrcode-wa', [DashboardController::class, 'generateQrcodeWa'])->name('dashboard.generateQrcodeWa');
    Route::get('start-session', [DashboardController::class, 'startSession'])->name('dashboard.startSession');
    Route::get('restart-session', [DashboardController::class, 'reStartSession'])->name('dashboard.reStartSession');
    
    //Menu Messages
    Route::resource('messages', MessageController::class);
    Route::post('direct-message', [MessageController::class, 'directMessage'])->name('messages.directMessage');
    Route::get('/admin/messages/blast/datatable', [MessageController::class, 'campaignDatatable'])->name('messages.campaignDatatable');
    Route::post('campaign/save', [MessageController::class, 'campaignStore'])->name('messages.campaignStore');
    Route::put('campaign/edit/{campaign_id}', [MessageController::class, 'campaignUpdate'])->name('messages.campaignUpdate');
    Route::delete('campaign/delete/{campaign_id}', [MessageController::class, 'campaignDestroy'])->name('messages.campaignDestroy');
    Route::post('/campaign/blast/{id}', [MessageController::class, 'blastCampaign'])->name('messages.blastCampaign');

    
    
    

    //Menu Transactions
    Route::resource('transactions', TransactionController::class);
    Route::get('/admin/transactions/datatable', [TransactionController::class, 'datatable'])->name('transactions.datatable');
    
});

// Route::post('/create-client-whatsapp', [DashboardController::class, 'createClinetWA'])
//         ->name('create-client-whatsapp.createClient');




require __DIR__.'/auth.php';

// Route::resource('contacts', ...) sudah otomatis menyediakan semua route standar termasuk:

// GET /contacts → index()

// POST /contacts → store()

// GET /contacts/create → create()

// PUT/PATCH /contacts/{contact} → update()
