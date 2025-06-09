<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'contact_id',
        'template_id',
        'user_id',
    ];

    // Relasi ke Contact
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    // Relasi ke Template
    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}


