<?php

namespace App\Imports;

use App\Models\PhoneNumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PhoneNumberImport implements ToModel, WithHeadingRow
{
    protected $contactId;

    public function __construct($contactId)
    {
        $this->contactId = $contactId;
    }

    

    public function model(array $row)
    { 
        // Cek apakah semua field penting ada dan tidak kosong/null
    if (
        isset($row['name'], $row['number']) &&
        !empty($row['name']) &&
        !empty($row['number'])
    ) {
        return new PhoneNumber([
            'contact_id' => $this->contactId,
            'name'       => $row['name'],
            'number'     => $row['number'],
        ]);
    }

    // Kalau tidak valid, bisa return null agar baris ini di-skip
    return null;
    }
}

